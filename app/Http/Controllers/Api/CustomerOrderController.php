<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerHoldstock;
use App\Models\CustomerOrderDetail;
use App\Models\CustomerPOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class CustomerOrderController extends Controller
{
    private const IDEMPOTENCY_ENDPOINT = 'api.customer-order.store';

    /**
     * Expects JSON or form-data with the same fields as the legacy endpoint.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'userID' => 'required|integer',
            'orderdate' => 'required|date',
            'remark' => 'nullable|string',
            'discountpresentage' => 'nullable|numeric',
            'total' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'nettotal' => 'required|numeric',
            'repname' => 'nullable|integer',
            'area' => 'nullable|integer',
            'customer' => 'required|integer',
            'locationID' => 'nullable|integer',
            'podiscount' => 'nullable|numeric',
            'tableData' => 'required',
        ]);

        $tableData = $request->input('tableData');
        if (is_string($tableData)) {
            $tableData = json_decode($tableData, true);
        }

        if (!is_array($tableData)) {
            return response()->json(['success' => false, 'message' => 'Invalid tableData'], 422);
        }

        $idempotencyKey = trim((string) $request->header('Idempotency-Key', ''));
        $idempotencyRecordId = null;

        if ($idempotencyKey !== '') {
            $requestHash = $this->buildRequestHash($validated, $tableData);

            $idempotencyCheck = $this->acquireIdempotencyKey(
                $idempotencyKey,
                (int) $validated['userID'],
                $requestHash,
                [
                    'validated' => $validated,
                    'tableData' => $tableData,
                ]
            );

            if (($idempotencyCheck['action'] ?? null) === 'replay') {
                return response()->json(
                    $idempotencyCheck['body'] ?? ['success' => false, 'message' => 'Duplicate request'],
                    (int) ($idempotencyCheck['status'] ?? 409)
                );
            }

            $idempotencyRecordId = $idempotencyCheck['id'] ?? null;
        }

        try {
            $result = DB::transaction(function () use ($validated, $tableData) {
                $now = Carbon::now()->toDateTimeString();

                $taxRow     = DB::table('tbl_tax')->select('rate')->limit(1)->first();
                $defaultTax = (float) ($taxRow->rate ?? 0);

                $cust    = Customer::select('vat_num')->where('idtbl_customer', $validated['customer'])->first();
                $taxRate = ($cust && !empty($cust->vat_num)) ? $defaultTax : 0.0;

                $grossTotal       = 0.0;   // sum of (qty * saleprice)          — VAT-inclusive
                $sumLineDiscounts = 0.0;   // sum of per-line discount amounts
                $sumLineTotals    = 0.0;   // sum of (lineGross - lineDiscount)

                foreach ($tableData as $item) {
                    $saleprice       = (float) (is_array($item) ? ($item['saleprice']       ?? 0) : ($item->saleprice       ?? 0));
                    $newqty          = (float) (is_array($item) ? ($item['newqty']          ?? 0) : ($item->newqty          ?? 0));
                    $discountPercent = (float) (is_array($item) ? ($item['discountpresent'] ?? 0) : ($item->discountpresent ?? 0));

                    $lineGross        = $newqty * $saleprice;
                    $lineDiscountAmt  = $lineGross * ($discountPercent / 100);
                    $lineTotal        = $lineGross - $lineDiscountAmt;

                    $grossTotal       += $lineGross;
                    $sumLineDiscounts += $lineDiscountAmt;
                    $sumLineTotals    += $lineTotal;
                }

                // PO-level discount applied on the VAT-inclusive subtotal
                $poDiscountPercent = (float) ($validated['discountpresentage'] ?? 0);
                $poDiscountAmount  = round($sumLineTotals * ($poDiscountPercent / 100), 2);
                $subtotalAfterPo   = $sumLineTotals - $poDiscountAmount;

                // VAT is extracted from the gross total (prices are VAT-inclusive)
                // Formula identical to NewCPOController::calculateOrderTotalsWithVat()
                $vatAmount = $taxRate > 0
                    ? round($grossTotal - ($grossTotal / (1 + ($taxRate / 100))), 2)
                    : 0.0;

                // nettotal = subtotal after all discounts (VAT already included in prices)
                $netTotal = round($subtotalAfterPo, 2);

                $prefix = 'CP/' . date('y/m/') . '%';
                $row    = DB::selectOne(
                    "SELECT MAX(cuspono) AS max_id FROM tbl_customer_order WHERE cuspono LIKE ?",
                    [$prefix]
                );
                $next_id = 1;
                if ($row && isset($row->max_id) && $row->max_id) {
                    if (preg_match('/(\d+)$/', $row->max_id, $matches)) {
                        $next_id = intval($matches[1]) + 1;
                    }
                }
                $cuspono = 'CP/' . date('y/m/') . str_pad($next_id, 4, '0', STR_PAD_LEFT);

                $orderId = CustomerPOrder::insertGetId([
                    'cuspono'              => $cuspono,
                    'date'                 => $validated['orderdate'],
                    'total'                => round($grossTotal, 2),        
                    'discount'             => round($sumLineDiscounts, 2), 
                    'podiscount'           => $poDiscountAmount,            
                    'podiscountpercentage' => $poDiscountPercent,
                    'vatpre'               => $taxRate,                     
                    'vat'                  => $vatAmount,                  
                    'nettotal'             => $netTotal,                  
                    'remark'               => $validated['remark'] ?? null,
                    'status'               => 1,
                    'insertdatetime'       => $now,
                    'tbl_user_idtbl_user'           => $validated['userID'],
                    'tbl_area_idtbl_area'           => $validated['area']       ?? null,
                    'tbl_employee_idtbl_employee'   => $validated['repname']    ?? null,
                    'tbl_locations_idtbl_locations' => $validated['locationID'] ?? null,
                    'tbl_customer_idtbl_customer'   => $validated['customer'],
                ]);

                $originalOrderId = DB::table('tbl_original_customer_order')->insertGetId([
                    'cuspono'              => $cuspono,
                    'date'                 => $validated['orderdate'],
                    'total'                => round($grossTotal, 2),
                    'discount'             => round($sumLineDiscounts, 2),
                    'podiscount'           => $poDiscountAmount,
                    'podiscountpercentage' => $poDiscountPercent,
                    'vatpre'               => $taxRate,                     
                    'vat'                  => $vatAmount,                   
                    'nettotal'             => $netTotal,                    
                    'remark'               => $validated['remark'] ?? null,
                    'status'               => 1,
                    'insertdatetime'       => $now,
                    'tbl_user_idtbl_user'           => $validated['userID'],
                    'tbl_area_idtbl_area'           => $validated['area']       ?? null,
                    'tbl_employee_idtbl_employee'   => $validated['repname']    ?? null,
                    'tbl_locations_idtbl_locations' => $validated['locationID'] ?? null,
                    'tbl_customer_idtbl_customer'   => $validated['customer'],
                    'tbl_customer_order_idtblcustomer_order' => $orderId,
                ]);

                foreach ($tableData as $item) {
                    $productID       = (int)   (is_array($item) ? ($item['productID']       ?? 0)  : ($item->productID       ?? 0));
                    $unitprice       = (float) (is_array($item) ? ($item['unitprice']       ?? 0)  : ($item->unitprice       ?? 0));
                    $saleprice       = (float) (is_array($item) ? ($item['saleprice']       ?? 0)  : ($item->saleprice       ?? 0));
                    $newqty          = (float) (is_array($item) ? ($item['newqty']          ?? 0)  : ($item->newqty          ?? 0));
                    $discountPercent = (float) (is_array($item) ? ($item['discountpresent'] ?? 0)  : ($item->discountpresent ?? 0));

                    $lineGross       = $newqty * $saleprice;
                    $lineDiscountAmt = round($lineGross * ($discountPercent / 100), 2);
                    $lineTotal       = round($lineGross - $lineDiscountAmt, 2);

                    CustomerOrderDetail::insert([
                        'orderqty'        => $newqty,
                        'confirmqty'      => $newqty,
                        'dispatchqty'     => $newqty,
                        'qty'             => $newqty,
                        'unitprice'       => $unitprice,
                        'saleprice'       => $saleprice,
                        'discountpresent' => $discountPercent,
                        'discount'        => $lineDiscountAmt, 
                        'total'           => $lineTotal,         
                        'status'          => 1,
                        'insertdatetime'  => $now,
                        'tbl_user_idtbl_user'                     => $validated['userID'],
                        'tbl_customer_order_idtbl_customer_order' => $orderId,
                        'tbl_product_idtbl_product'               => $productID,
                    ]);

                    DB::table('tbl_original_customer_order_detail')->insert([
                        'orderqty'        => $newqty,
                        'confirmqty'      => $newqty,
                        'dispatchqty'     => $newqty,
                        'qty'             => $newqty,
                        'unitprice'       => $unitprice,
                        'saleprice'       => $saleprice,
                        'discountpresent' => $discountPercent,
                        'discount'        => $lineDiscountAmt,
                        'total'           => $lineTotal,
                        'status'          => 1,
                        'insertdatetime'  => $now,
                        'tbl_user_idtbl_user' => $validated['userID'],
                        'tbl_original_customer_order_idtbl_original_customer_order' => $originalOrderId,
                        'tbl_product_idtbl_product' => $productID,
                    ]);

                    CustomerHoldstock::insert([
                        'qty'             => $newqty,
                        'invoiceissue'    => 0,
                        'status'          => 1,
                        'insertdatetime'  => $now,
                        'tbl_user_idtbl_user'                     => $validated['userID'],
                        'tbl_product_idtbl_product'               => $productID,
                        'tbl_customer_order_idtbl_customer_order' => $orderId,
                    ]);
                }

                return ['orderId' => $orderId, 'cuspono' => $cuspono];
            });

            $responseBody = ['success' => true, 'message' => 'Added successfully', 'data' => $result];

            if ($idempotencyRecordId) {
                $this->finalizeIdempotencyRecord($idempotencyRecordId, 2, 200, $responseBody);
            }

            return response()->json($responseBody);
        } catch (\Throwable $e) {
            $errorBody = ['success' => false, 'message' => $e->getMessage()];

            if ($idempotencyRecordId) {
                $this->finalizeIdempotencyRecord($idempotencyRecordId, 3, 500, $errorBody);
            }

            Log::error('Mobile order error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json($errorBody, 500);
        }
    }

    private function acquireIdempotencyKey(string $key, int $userId, string $requestHash, array $requestPayload): array
    {
        $now = Carbon::now()->toDateTimeString();

        try {
            $id = DB::table('tbl_api_idempotency')->insertGetId([
                'idempotency_key' => $key,
                'endpoint' => self::IDEMPOTENCY_ENDPOINT,
                'request_hash' => $requestHash,
                'request_body' => json_encode($requestPayload, JSON_UNESCAPED_UNICODE),
                'response_status' => null,
                'response_body' => null,
                'process_status' => 1,
                'status' => 1,
                'insertdatetime' => $now,
                'updatedatetime' => $now,
                'tbl_user_idtbl_user' => $userId,
            ]);

            return ['action' => 'process', 'id' => $id];
        } catch (QueryException $e) {
            $mysqlDuplicateEntryCode = 1062;
            $sqlState = (string) ($e->errorInfo[0] ?? '');
            $driverErrorCode = (int) ($e->errorInfo[1] ?? 0);
            $isDuplicateKey = $driverErrorCode === $mysqlDuplicateEntryCode || $sqlState === '23000';

            if (!$isDuplicateKey) {
                throw $e;
            }

            $existing = DB::table('tbl_api_idempotency')
                ->where('idempotency_key', $key)
                ->where('endpoint', self::IDEMPOTENCY_ENDPOINT)
                ->where('tbl_user_idtbl_user', $userId)
                ->first();

            if (!$existing) {
                throw $e;
            }

            if (($existing->request_hash ?? '') !== $requestHash) {
                return [
                    'action' => 'replay',
                    'status' => 409,
                    'body' => [
                        'success' => false,
                        'message' => 'Idempotency key reused with different payload',
                    ],
                ];
            }

            $processStatus = (int) ($existing->process_status ?? 0);

            if ($processStatus === 1) {
                return [
                    'action' => 'replay',
                    'status' => 409,
                    'body' => [
                        'success' => false,
                        'message' => 'Request is already being processed. Please retry shortly.',
                    ],
                ];
            }

            $savedBody = json_decode((string) ($existing->response_body ?? ''), true);
            $savedStatus = (int) ($existing->response_status ?? 0);

            return [
                'action' => 'replay',
                'status' => $savedStatus > 0 ? $savedStatus : ($processStatus === 2 ? 200 : 500),
                'body' => is_array($savedBody)
                    ? $savedBody
                    : [
                        'success' => $processStatus === 2,
                        'message' => $processStatus === 2 ? 'Duplicate request replayed' : 'Previous request failed',
                    ],
            ];
        }
    }

    private function finalizeIdempotencyRecord(int $recordId, int $processStatus, int $responseStatus, array $responseBody): void
    {
        DB::table('tbl_api_idempotency')
            ->where('idtbl_api_idempotency', $recordId)
            ->update([
                'process_status' => $processStatus,
                'response_status' => $responseStatus,
                'response_body' => json_encode($responseBody, JSON_UNESCAPED_UNICODE),
                'updatedatetime' => Carbon::now()->toDateTimeString(),
            ]);
    }

    private function buildRequestHash(array $validated, array $tableData): string
    {
        $payload = [
            'userID' => (int) ($validated['userID'] ?? 0),
            'orderdate' => (string) ($validated['orderdate'] ?? ''),
            'remark' => (string) ($validated['remark'] ?? ''),
            'discountpresentage' => (float) ($validated['discountpresentage'] ?? 0),
            'total' => (float) ($validated['total'] ?? 0),
            'discount' => (float) ($validated['discount'] ?? 0),
            'nettotal' => (float) ($validated['nettotal'] ?? 0),
            'repname' => (int) ($validated['repname'] ?? 0),
            'area' => (int) ($validated['area'] ?? 0),
            'customer' => (int) ($validated['customer'] ?? 0),
            'locationID' => (int) ($validated['locationID'] ?? 0),
            'podiscount' => (float) ($validated['podiscount'] ?? 0),
            'tableData' => $this->normalizeForHash($tableData),
        ];

        return hash('sha256', json_encode($payload, JSON_UNESCAPED_UNICODE));
    }

    private function normalizeForHash(mixed $value): mixed
    {
        if (is_object($value)) {
            $value = (array) $value;
        }

        if (!is_array($value)) {
            return $value;
        }

        if (array_is_list($value)) {
            return array_map(fn($item) => $this->normalizeForHash($item), $value);
        }

        ksort($value);
        foreach ($value as $key => $item) {
            $value[$key] = $this->normalizeForHash($item);
        }

        return $value;
    }
}
