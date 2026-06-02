<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HasInvoicePayment;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\InvoicePaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadInvoicePaymentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'refId' => 'required|integer',
            'totAmount' => 'nullable|numeric',
            'payAmount' => 'required|numeric',
            'balAmount' => 'required|numeric',
            'invoicePaymentArray' => 'required',
            'customerPaymentArray' => 'required',
        ]);

        $invoiceRows = $request->input('invoicePaymentArray');
        $paymentRows = $request->input('customerPaymentArray');

        if (is_string($invoiceRows)) {
            $invoiceRows = json_decode($invoiceRows, true);
        }

        if (is_string($paymentRows)) {
            $paymentRows = json_decode($paymentRows, true);
        }

        if (!is_array($invoiceRows) || !is_array($paymentRows)) {
            return response()->json(['code' => '500', 'message' => 'Update Not Complete'], 422);
        }

        try {
            DB::transaction(function () use ($validated, $invoiceRows, $paymentRows) {
                $payment = InvoicePayment::create([
                    'date' => now()->toDateString(),
                    'payment' => $validated['payAmount'],
                    'balance' => $validated['balAmount'],
                    'status' => 1,
                    'updatedatetime' => now(),
                    'tbl_user_idtbl_user' => $validated['refId'],
                ]);

                foreach ($invoiceRows as $row) {
                    $invoiceId = (int) ($row['invoiceid'] ?? 0);
                    $invoiceTotal = (float) ($row['invoicetotal'] ?? 0);
                    $payAmount = (float) ($row['newPaymentAmount'] ?? 0);
                    $discount = (float) ($row['discount'] ?? 0);

                    if ($invoiceId <= 0 || $payAmount <= 0) {
                        continue;
                    }

                    $fullStatus = $invoiceTotal <= $payAmount ? 1 : 0;
                    $halfStatus = $fullStatus === 1 ? 0 : 1;

                    Invoice::where('idtbl_invoice', $invoiceId)->update([
                        'paymentcomplete' => $fullStatus,
                        'updatedatetime' => now(),
                        'tbl_user_idtbl_user' => $validated['refId'],
                    ]);

                    HasInvoicePayment::create([
                        'tbl_invoice_payment_idtbl_invoice_payment' => $payment->idtbl_invoice_payment,
                        'tbl_invoice_idtbl_invoice' => $invoiceId,
                        'total' => $invoiceTotal,
                        'discount' => $discount,
                        'payamount' => $payAmount,
                        'fullstatus' => $fullStatus,
                        'halfstatus' => $halfStatus,
                    ]);
                }

                foreach ($paymentRows as $row) {
                    $methodName = strtolower(trim((string) ($row['method'] ?? '')));
                    $method = $methodName === 'cash' ? 1 : 2;

                    InvoicePaymentDetail::create([
                        'method' => $method,
                        'amount' => $row['amount'] ?? 0,
                        'branch' => $row['branch'] ?? '',
                        'receiptno' => $row['receiptno'] ?? '',
                        'chequeno' => $row['chequeno'] ?? '',
                        'chequedate' => $row['chequedate'] ?? null,
                        'status' => 1,
                        'updatedatetime' => now(),
                        'tbl_bank_idtbl_bank' => $row['bankId'] ?? null,
                        'tbl_user_idtbl_user' => $validated['refId'],
                        'tbl_invoice_payment_idtbl_invoice_payment' => $payment->idtbl_invoice_payment,
                    ]);
                }
            });

            return response()->json(['code' => '200', 'message' => 'Update Complete']);
        } catch (\Throwable $e) {
            return response()->json(['code' => '500', 'message' => 'Update Not Complete'], 500);
        }
    }
}
