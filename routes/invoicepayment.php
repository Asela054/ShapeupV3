<?php

use Illuminate\Support\Facades\Route;

Route::prefix('invoicepayment')->group(function () {
    /**
     * Get customer list for Select2 AJAX
     * Search by customer name
     */
    Route::post('get-customers', function () {
        $searchTerm = request('searchTerm', '');
        
        // Mock data - Customer list
        $customers = [
            ['id' => 1, 'text' => 'ABC Trading Company', 'name' => 'ABC Trading Company'],
            ['id' => 2, 'text' => 'XYZ Enterprises', 'name' => 'XYZ Enterprises'],
            ['id' => 3, 'text' => 'Global Supplies Ltd', 'name' => 'Global Supplies Ltd'],
            ['id' => 4, 'text' => 'Premium Wholesalers', 'name' => 'Premium Wholesalers'],
            ['id' => 5, 'text' => 'Mega Retail Co', 'name' => 'Mega Retail Co'],
            ['id' => 6, 'text' => 'Elite Distribution', 'name' => 'Elite Distribution'],
        ];

        // Filter by search term
        if ($searchTerm) {
            $customers = array_filter($customers, function ($customer) use ($searchTerm) {
                return stripos($customer['text'], $searchTerm) !== false;
            });
        }

        return response()->json(array_values($customers));
    });

    /**
     * Get invoices for payment
     * Filter by customer ID or invoice number
     */
    Route::post('get-invoices', function () {
        $customerID = request('customerID', '');
        $invoiceno = request('invoiceno', '');

        // Mock data - Invoices
        $invoices = [
            [
                'invoice_no' => 'INV-001-2024',
                'invoice_date' => '2024-12-01',
                'customer_id' => 1,
                'customer_name' => 'ABC Trading Company',
                'invoice_amount' => 15000.00,
                'paid_amount' => 5000.00,
                'balance' => 10000.00,
            ],
            [
                'invoice_no' => 'INV-002-2024',
                'invoice_date' => '2024-12-05',
                'customer_id' => 1,
                'customer_name' => 'ABC Trading Company',
                'invoice_amount' => 22500.50,
                'paid_amount' => 0.00,
                'balance' => 22500.50,
            ],
            [
                'invoice_no' => 'INV-003-2024',
                'invoice_date' => '2024-12-10',
                'customer_id' => 2,
                'customer_name' => 'XYZ Enterprises',
                'invoice_amount' => 18000.00,
                'paid_amount' => 8000.00,
                'balance' => 10000.00,
            ],
            [
                'invoice_no' => 'INV-004-2024',
                'invoice_date' => '2024-12-12',
                'customer_id' => 3,
                'customer_name' => 'Global Supplies Ltd',
                'invoice_amount' => 45000.75,
                'paid_amount' => 0.00,
                'balance' => 45000.75,
            ],
            [
                'invoice_no' => 'INV-005-2024',
                'invoice_date' => '2024-12-15',
                'customer_id' => 4,
                'customer_name' => 'Premium Wholesalers',
                'invoice_amount' => 32000.00,
                'paid_amount' => 16000.00,
                'balance' => 16000.00,
            ],
            [
                'invoice_no' => 'INV-006-2024',
                'invoice_date' => '2024-12-18',
                'customer_id' => 5,
                'customer_name' => 'Mega Retail Co',
                'invoice_amount' => 28500.00,
                'paid_amount' => 28500.00,
                'balance' => 0.00,
            ],
        ];

        // Filter by customer ID
        if ($customerID) {
            $invoices = array_filter($invoices, function ($invoice) use ($customerID) {
                return (string)$invoice['customer_id'] === (string)$customerID;
            });
        }

        // Filter by invoice number
        if ($invoiceno) {
            $invoices = array_filter($invoices, function ($invoice) use ($invoiceno) {
                return stripos($invoice['invoice_no'], $invoiceno) !== false;
            });
        }

        // Return JSON data instead of HTML
        return response()->json(array_values($invoices));
    });

    /**
     * Get credit notes list for Select2 AJAX
     */
    Route::post('get-credit-notes', function () {
        $customerID = request('customerID', '');

        // Mock data - Credit notes
        $creditNotes = [
            [
                'id' => 'CN-001',
                'text' => 'Credit Note CN-001 - Rs. 2,500.00',
                'amount' => 2500.00,
                'customer_id' => 1,
            ],
            [
                'id' => 'CN-002',
                'text' => 'Credit Note CN-002 - Rs. 1,800.00',
                'amount' => 1800.00,
                'customer_id' => 2,
            ],
            [
                'id' => 'CN-003',
                'text' => 'Credit Note CN-003 - Rs. 3,200.00',
                'amount' => 3200.00,
                'customer_id' => 3,
            ],
            [
                'id' => 'CN-004',
                'text' => 'Credit Note CN-004 - Rs. 1,500.00',
                'amount' => 1500.00,
                'customer_id' => 1,
            ],
        ];

        // Filter by customer ID if provided
        if ($customerID) {
            $creditNotes = array_filter($creditNotes, function ($note) use ($customerID) {
                return (string)$note['customer_id'] === (string)$customerID;
            });
        }

        $result = array_map(function ($note) {
            return [
                'id' => $note['id'],
                'text' => $note['text'],
                'data-creditnoteamount' => $note['amount'],
            ];
        }, array_values($creditNotes));

        return response()->json($result);
    });

    /**
     * Get banks list for Select2 AJAX
     */
    Route::post('get-banks', function () {
        // Mock data - Banks
        $banks = [
            ['id' => 1, 'text' => 'Commercial Bank PLC'],
            ['id' => 2, 'text' => 'Sampath Bank'],
            ['id' => 3, 'text' => 'DFCC Bank'],
            ['id' => 4, 'text' => 'HNB'],
            ['id' => 5, 'text' => 'People\'s Bank'],
            ['id' => 6, 'text' => 'Union Bank'],
            ['id' => 7, 'text' => 'Seylan Bank'],
        ];

        return response()->json($banks);
    });

    /**
     * Process payment receipt
     */
    Route::post('process-payment', function () {
        $paymentDate = request('paymentdate');
        $totalAmount = request('totAmount');

        // Generate mock payment ID
        $paymentID = 'PAY-' . strtoupper(uniqid());

        // Mock response
        return response()->json([
            'paymentinvoice' => rand(1000, 9999),
            'paymentid' => $paymentID,
            'message' => 'Payment processed successfully!',
            'action' => json_encode([
                'type' => 'success',
                'icon' => 'success',
                'title' => 'Success',
                'message' => 'Payment receipt issued successfully!',
            ])
        ]);
    });

    /**
     * Get payment receipt
     */
    Route::post('get-receipt', function () {
        $paymentID = request('paymentinoiceID');

        $html = '<div class="invoice-receipt">';
        $html .= '<div class="text-center mb-4">';
        $html .= '<h3 class="fw-bold">PAYMENT RECEIPT</h3>';
        $html .= '</div>';
        $html .= '<hr>';

        $html .= '<div class="row mb-3">';
        $html .= '<div class="col-6">';
        $html .= '<p><strong>Receipt Number:</strong> REC-' . $paymentID . '</p>';
        $html .= '<p><strong>Date:</strong> ' . date('Y-m-d') . '</p>';
        $html .= '</div>';
        $html .= '<div class="col-6 text-end">';
        $html .= '<p><strong>Payment ID:</strong> PAY-' . rand(1000, 9999) . '</p>';
        $html .= '<p><strong>Time:</strong> ' . date('H:i:s') . '</p>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<hr>';

        $html .= '<div class="row mb-3">';
        $html .= '<div class="col-6">';
        $html .= '<p><strong>Customer:</strong> ABC Trading Company</p>';
        $html .= '<p><strong>Address:</strong> 123 Business Street, City</p>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<hr>';

        $html .= '<div class="table-responsive mb-3">';
        $html .= '<table class="table table-sm table-bordered">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Invoice No</th>';
        $html .= '<th class="text-end">Amount</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td>INV-001-2024</td>';
        $html .= '<td class="text-end">Rs. 10,000.00</td>';
        $html .= '</tr>';
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';

        $html .= '<div class="row">';
        $html .= '<div class="col-6 offset-6">';
        $html .= '<div class="d-flex justify-content-between mb-2"><span>Total Amount:</span><span class="fw-bold">Rs. 10,000.00</span></div>';
        $html .= '<div class="d-flex justify-content-between mb-2"><span>Paid Amount:</span><span class="fw-bold">Rs. 10,000.00</span></div>';
        $html .= '<div class="d-flex justify-content-between border-top pt-2"><span class="fw-bold">Balance:</span><span class="fw-bold">Rs. 0.00</span></div>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<hr class="my-4">';

        $html .= '<div class="text-center mt-4">';
        $html .= '<p class="text-muted small">Thank you for your payment!</p>';
        $html .= '<p class="text-muted small">' . (config('company.name') ?? 'ERAV') . ' (PVT) LTD</p>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    });
});
