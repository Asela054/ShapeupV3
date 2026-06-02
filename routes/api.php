<?php

use App\Http\Controllers\Api\AllCustomersController;
use App\Http\Controllers\Api\AllLocationController;
use App\Http\Controllers\Api\AllProductController;
use App\Http\Controllers\Api\AllSubCategoriesController;
use App\Http\Controllers\Api\AreasController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\BankBranchesController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\CatalogDetailsController;
use App\Http\Controllers\Api\CreditInfoOfCustomerController;
use App\Http\Controllers\Api\AccountsController;
use App\Http\Controllers\Api\CustomerAvailableQtyController;
use App\Http\Controllers\Api\CustomerForPOrder;
use App\Http\Controllers\Api\AllGroupCategoriesController;
use App\Http\Controllers\Api\CustomerPOrderController;
use App\Http\Controllers\Api\CustomerPOrderListController;
use App\Http\Controllers\Api\CustomerPriceListController;
use App\Http\Controllers\Api\CustomerViceOutstandingForRepController;
use App\Http\Controllers\Api\GroupCategoryController;
use App\Http\Controllers\Api\KpiDataController;
use App\Http\Controllers\Api\MainInvoiceController;
use App\Http\Controllers\Api\ManagerWiseRepsDailySalesController;
use App\Http\Controllers\Api\MonthlySalesController;
use App\Http\Controllers\Api\OutstandingForRepController;
use App\Http\Controllers\Api\OutstandingForRepViseCustomerController;
use App\Http\Controllers\Api\PaymentSummeryController;
use App\Http\Controllers\Api\ProductFreeIssueController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\RefWiseMonthlyDataController;
use App\Http\Controllers\Api\RefsCustomersController;
use App\Http\Controllers\Api\RejectReasonController;
use App\Http\Controllers\Api\RepListController;
use App\Http\Controllers\Api\RepsDailySalesController;
use App\Http\Controllers\Api\SalesManagersRepsController;
use App\Http\Controllers\Api\SalesRefsCustomersController;
use App\Http\Controllers\Api\SalesRepDetailsController;
use App\Http\Controllers\Api\SalesRepsAreaController;
use App\Http\Controllers\Api\SalesRepsController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\SubProductFromProductController;
use App\Http\Controllers\Api\SuppliersController;
use App\Http\Controllers\Api\UnpaindInvoiceController;
use App\Http\Controllers\Api\UploadInvoicePaymentController;
use App\Http\Controllers\Api\VehicleLoadingDataController;
use App\Http\Controllers\Api\YearMonthDaySummaryByRefController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\CatalogImageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerOrderController;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\AreasByProvinceController;
use App\Http\Controllers\Api\CustomerRegController;
use App\Http\Controllers\Api\ProvinceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/health', function () {
    // Basic health check
    return response()->json(['status' => 'healthy', 'timestamp' => now()]);
});

// Route::post('/shutdown', function () {
//     // Graceful shutdown for load balancer


//     // Set a flag to indicate shutdown
//     cache()->put('app_shutting_down', true, 300); // 5 minutes
//     return response()->json(['message' => 'Shutdown initiated']);
// })->middleware('auth:sanctum'); // Protect this route

// Update health check to check shutdown flag
// Route::get('/health', function () {
//     if (cache()->get('app_shutting_down')) {
//         return response()->json(['status' => 'shutting_down'], 503);
//     }
//     return response()->json(['status' => 'healthy', 'timestamp' => now()]);
// });


Route::post('/legacy-login', function(Request $request) {
    try {
        if (Auth::attempt([
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ])) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->idtbl_user,
                    'name' => $user->name,
                    'username' => $user->username,
                    'tbl_user_type_idtbl_user_type' => $user->tbl_user_type_idtbl_user_type ?? null,
                    'imagepath' => $user->imagepath ?? null,
                ]
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
    } catch (\Throwable $e) {
        Log::error('Legacy login error: ' . $e->getMessage(), ['exception' => $e]);
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
});


Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
// Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api');

// customerpordermobileprocess.php
Route::post('/customer-order', [CustomerOrderController::class, 'store'])->middleware('auth:api');

// getallareas.php
Route::get('/areas', [AreaController::class, 'index'])->middleware('auth:api');

// Banks
Route::get('/banks', [BankController::class, 'index'])->middleware('auth:api');

// Legacy getallcatalogimages endpoint
Route::get('/catalog-images', [CatalogImageController::class, 'index'])->middleware('auth:api');

// getallcustomerforporder.php
Route::get('/customers-for-porder', [CustomerForPOrder::class, 'index'])->middleware('auth:api');

// getallcustomers.php
Route::get('/all-customers', [AllCustomersController::class, 'index'])->middleware('auth:api');

// getallgroupcategories.php
Route::get('/all-group-categories', [AllGroupCategoriesController::class, 'index'])->middleware('auth:api');

//getalllocations.php
Route::get('/all-locations', [AllLocationController::class, 'index'])->middleware('auth:api');

//getAllMonthSale.php
Route::post('/monthly-sales', [MonthlySalesController::class, 'index'])->middleware('auth:api');

// getalloutstandingforrep.php
Route::post('/outstanding-for-rep', [OutstandingForRepController::class, 'index'])->middleware('auth:api');

// getalloutstandingforrepvisecustomer.php
Route::post('/outstanding-for-rep-customer', [OutstandingForRepViseCustomerController::class, 'index'])->middleware('auth:api');

// getAllProduct.php
Route::get('/all-products', [AllProductController::class, 'index'])->middleware('auth:api');

// getallproductswithstock.php
Route::get('/product-with-stock', [AllProductController::class, 'indexWithStock'])->middleware('auth:api');

// getAllRejectReason.php
Route::get('/reject-reasons', [RejectReasonController::class, 'index'])->middleware('auth:api');


// getallsalesrepsaccosalesmanager.php
Route::post('/sales-rep-details', [SalesRepDetailsController::class, 'index'])->middleware('auth:api');

// getallsalesreps.php
Route::get('/sales-reps', [SalesRepsController::class, 'index'])->middleware('auth:api');

// getallsalesmanagersreps.php
Route::post('/sales-managers-reps', [SalesManagersRepsController::class, 'index'])->middleware('auth:api');

// getallsubcategories.php
Route::get('/all-subcategories', [AllSubCategoriesController::class, 'index'])->middleware('auth:api');

// getallsuppliers.php
Route::get('/all-suppliers', [SuppliersController::class, 'index'])->middleware('auth:api');

// getarea.php
Route::get('/all-areas', [AreasController::class, 'index'])->middleware('auth:api');

Route::get('/all-provinces', [ProvinceController::class, 'index'])->middleware('auth:api');

Route::get('/areas-by-province', [AreasByProvinceController::class, 'index'])->middleware('auth:api');

// getcatalog.php
Route::get('/all-catalog', [CatalogController::class, 'index'])->middleware('auth:api');

// getcatalogdetails.php
Route::post('/catalog-details', [CatalogDetailsController::class, 'index'])->middleware('auth:api');

// getcreditinfoaccocustomer.php
Route::post('/customer-credit-info', [CreditInfoOfCustomerController::class, 'index'])->middleware('auth:api');

// getCustomerPriceList.php

Route::get('/customer-price-list', [CustomerPriceListController::class, 'index'])->middleware('auth:api');

// getCustomersAccoRef.php
Route::post('/customers-by-ref', [RefsCustomersController::class, 'index'])->middleware('auth:api');

// getcustomersaccosalesrep.php
Route::post('/customers-by-sales-rep', [SalesRefsCustomersController::class, 'index'])->middleware('auth:api');

// getcustomerviseoutstandingforrep.php
Route::post('/customer-outstanding-for-rep', [CustomerViceOutstandingForRepController::class, 'index'])->middleware('auth:api');

// getcustoomerpordersformobile.php
Route::post('/customer-orders', [CustomerPOrderController::class, 'index'])->middleware('auth:api');

// getcustomerporderlist.php
Route::post('/customer-porder-list', [CustomerPOrderListController::class, 'index'])->middleware('auth:api');

// getAccounts.php
Route::get('/accounts', [AccountsController::class, 'index'])->middleware('auth:api');

// getAllBankBranches.php
Route::get('/bank-branches', [BankBranchesController::class, 'index'])->middleware('auth:api');

// getkpidata.php
Route::get('/kpi-data', [KpiDataController::class, 'index'])->middleware('auth:api');

// getProductFreeIssue.php
Route::get('/product-free-issues', [ProductFreeIssueController::class, 'index'])->middleware('auth:api');

// getreplist.php
Route::post('/rep-list', [RepListController::class, 'index'])->middleware('auth:api');

// getVehicleLoadingDetails.php
Route::get('/vehicle-loading-details', [VehicleLoadingDataController::class, 'show'])->middleware('auth:api');

// uploadCustomerAvailableQty.php
Route::post('/customer-available-qty', [CustomerAvailableQtyController::class, 'store'])->middleware('auth:api');

// uploadInvoicePayment.php
Route::post('/upload-invoice-payment', [UploadInvoicePaymentController::class, 'store'])->middleware('auth:api');

// getGroupCategory.php
Route::get('/group-categories', [GroupCategoryController::class, 'index'])->middleware('auth:api');

// getMainInvoice.php
Route::post('/main-invoice', [MainInvoiceController::class, 'index'])->middleware('auth:api');

// getmanagervisesalesrepdailysales.php
Route::post('/manager-wise-reps-daily-sales', [ManagerWiseRepsDailySalesController::class, 'index'])->middleware('auth:api');

// getOldInvoice.php


// getPaymentSummery.php
Route::post('/payment-summary', [PaymentSummeryController::class, 'index'])->middleware('auth:api');

// getProductCategory.php
Route::get('/product-categories', [ProductCategoryController::class, 'index'])->middleware('auth:api');

// getRefWiseMonthlyData.php
Route::get('/ref-wise-monthly-data', [RefWiseMonthlyDataController::class, 'index'])->middleware('auth:api');


// getsalereparealist.php
Route::post('/sales-reps-area', [SalesRepsAreaController::class, 'index'])->middleware('auth:api');

// getsalesrepdailysales.php
Route::post('/sales-reps-daily-sales', [RepsDailySalesController::class, 'index'])->middleware('auth:api');

// getSubCategory.php
Route::get('/sub-categories', [SubCategoryController::class, 'index'])->middleware('auth:api');

// getsubproductsaccoproductgroup.php
Route::post('/sub-products-by-product-group', [SubProductFromProductController::class, 'index'])->middleware('auth:api');

// getUnpaidInvoice.php
Route::post('/unpaid-invoices', [UnpaindInvoiceController::class, 'index'])->middleware('auth:api');

// getYearMonthDaySummeryRef.php
Route::post('/year-month-day-summary-by-ref', [YearMonthDaySummaryByRefController::class, 'index'])->middleware('auth:api');

Route::post('/customer-register', [CustomerRegController::class, 'store']);