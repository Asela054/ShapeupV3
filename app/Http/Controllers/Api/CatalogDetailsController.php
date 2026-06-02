<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CatalogDetail;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class CatalogDetailsController extends Controller
{
    public function index(Request $request)
    {
        $catalogId = (int) $request->input('catalogcategoryid', 0);

        if ($catalogId <= 0) {
            return response()->json([
                'product_details' => [],
                'product_images' => [],
            ]);
        }

        // $productDetails = CatalogDetail::query()
        //     ->select([
        //         'idtbl_catalog_details',
        //         'product_name',
        //         'tbl_catalog_idtbl_catalog',
        //     ])
        //     ->where('tbl_catalog_idtbl_catalog', $catalogId)
        //     ->where('status', 1)
        //     ->with([
        //         'catalog:idtbl_catalog,tbl_catalog_category_idtbl_catalog_category',
        //         'catalog.catalogCategory:idtbl_catalog_category,sequence',
        //         'product:idtbl_product,product_name,saleprice',
        //         'product.activeStocks:idtbl_stock,tbl_product_idtbl_product,qty',
        //         'product.holdStocks:idtbl_customer_order_hold_stock,tbl_product_idtbl_product,qty',
        //     ])
        //     ->get()
        //     ->map(function ($row) {
        //         $fullQty = (float) $row->product?->activeStocks?->sum('qty');
        //         $holdQty = (float) $row->product?->holdStocks?->sum('qty');
        //         $availableQty = $fullQty - $holdQty;

        //         if ($availableQty <= 0) {
        //             return null;
        //         }

        //         return [
        //             'id' => (string) $row->idtbl_catalog_details,
        //             'name' => $row->product?->product_name,
        //             'productID' => (string) $row->product_name,
        //             'price' => (string) ($row->product?->saleprice ?? 0),
        //             'fullQty' => (string) $fullQty,
        //             'holdqty' => (string) $holdQty,
        //             'availableQty' => (string) $availableQty,
        //             'sequence' => (string) ($row->catalog?->catalogCategory?->sequence ?? 0),
        //         ];
        //     })
        //     ->filter()
        //     ->sortBy('sequence')
        //     ->values();
        $productDetails = Product::query()
            ->select(['idtbl_product', 'product_name', 'saleprice'])
            ->whereHas('productcategory', function ($query) use ($catalogId) {
                $query->where('idtbl_product_category', $catalogId)
                    ->where('status', 1);
            })
            ->withSum('activeStocks as fullQty', 'qty')
            ->withSum('holdStocks as holdQty', 'qty')
            ->get()
            ->map(function ($product) {
                $availableQty = (float) $product->fullQty - (float) $product->holdQty;

                if ($availableQty <= 0) {
                    return null;
                }

                return [
                    'id' => (string) $product->idtbl_product,
                    'name' => $product->product_name,
                    'productID' => (string) $product->idtbl_product,
                    'price' => (string) ($product->saleprice ?? 0),
                    'fullQty' => (string) $product->fullQty,
                    'holdqty' => (string) $product->holdQty,
                    'availableQty' => (string) $availableQty,
                ];
            })
            ->filter()
            ->values();

        $productImages = ProductImage::query()
            ->select(['idtbl_product_image', 'imagepath'])
            ->where('tbl_catalog_idtbl_catalog', $catalogId)
            ->get()
            ->map(fn ($image) => [
                'imagepath' => $image->imagepath,
                'id' => (string) $image->idtbl_product_image,
            ])
            ->values();

        return response()->json([
            'product_details' => $productDetails,
            'product_images' => $productImages,
        ]);
    }
}
