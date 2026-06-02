<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllProductController extends Controller
{
    public function index(){
        $products = Product::where('status', 1)->get();

        $result = $products->map(function ($product) {
            return [
                'id' => (string) $product->idtbl_product,
                'product_code' => (string) $product->product_code,
                'product_name' => (string) $product->product_name,
                'size' => (string) $product->size,
                'unitprice' => (string) number_format((float) $product->unitprice, 2, '.', ''),
                'saleprice' => (string) number_format((float) $product->saleprice, 2, '.', ''),
                'category' => (string) $product->tbl_product_category_idtbl_product_category,
                'groupCategory' => (string) $product->tbl_group_category_idtbl_group_category,
                'subCategory' => (string) $product->tbl_sub_product_category_idtbl_sub_product_category,
            ];
        });

        return response()->json($result, 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function indexWithStock()
    {
        $products = Product::query()
            ->leftJoin('tbl_product_category as c', 'tbl_product.tbl_product_category_idtbl_product_category', '=', 'c.idtbl_product_category')
            ->leftJoin('tbl_stock as s', 'tbl_product.idtbl_product', '=', 's.tbl_product_idtbl_product')
            ->select([
                'tbl_product.idtbl_product',
                'tbl_product.product_name',
                'tbl_product.product_code',
                'tbl_product.unitprice',
                'tbl_product.saleprice',
                'tbl_product.barcode',
                'tbl_product.rol',
                'tbl_product.pices_per_box',
                'tbl_product.retail',
                'tbl_product.starpoints',
                'tbl_product.tbl_product_category_idtbl_product_category',
                'tbl_product.tbl_group_category_idtbl_group_category',
                'tbl_product.tbl_sub_product_category_idtbl_sub_product_category',
                'tbl_product.tbl_supplier_idtbl_supplier',
                'tbl_product.salediscount',
                'tbl_product.retaildiscount',
                'tbl_product.price_acceptable',
                'tbl_product.additional_discount',
                'tbl_product.common_name',
                'tbl_product.tbl_sizes_idtbl_sizes',
                'tbl_product.tbl_size_categories_idtbl_size_categories',
                'tbl_product.productimagepath',
                'c.category as categoryName',
                DB::raw('COALESCE(SUM(s.qty), 0) as qty'),
            ])
            ->groupBy([
                'tbl_product.idtbl_product',
                'tbl_product.product_name',
                'tbl_product.product_code',
                'tbl_product.unitprice',
                'tbl_product.saleprice',
                'tbl_product.barcode',
                'tbl_product.rol',
                'tbl_product.pices_per_box',
                'tbl_product.retail',
                'tbl_product.starpoints',
                'tbl_product.tbl_product_category_idtbl_product_category',
                'tbl_product.tbl_group_category_idtbl_group_category',
                'tbl_product.tbl_sub_product_category_idtbl_sub_product_category',
                'tbl_product.tbl_supplier_idtbl_supplier',
                'tbl_product.salediscount',
                'tbl_product.retaildiscount',
                'tbl_product.price_acceptable',
                'tbl_product.additional_discount',
                'tbl_product.common_name',
                'tbl_product.tbl_sizes_idtbl_sizes',
                'tbl_product.tbl_size_categories_idtbl_size_categories',
                'tbl_product.productimagepath',
                'c.category',
            ])
            ->get();

        $result = $products->map(function ($row) {
            return [
                'id' => (string)$row->idtbl_product,
                'product_name' => $row->product_name,
                'productcode' => (string)$row->product_code,
                'unitprice' => (string)$row->unitprice,
                'saleprice' => (string)$row->saleprice,
                'barcode' => (string)$row->barcode,
                'rol' => (string)$row->rol,
                'pices_per_box' => (string)$row->pices_per_box,
                'retail' => (string)$row->retail,
                'starpoints' => (string)$row->starpoints,
                'category' => (string)$row->tbl_product_category_idtbl_product_category,
                'groupcategory' => (string)$row->tbl_group_category_idtbl_group_category,
                'subcategory' => (string)$row->tbl_sub_product_category_idtbl_sub_product_category,
                'supplier' => (string)$row->tbl_supplier_idtbl_supplier,
                'salediscount' => (string)$row->salediscount,
                'retaildiscount' => (string)$row->retaildiscount,
                'radioprice' => (string)$row->price_acceptable,
                'additionaldiscount' => (string)$row->additional_discount,
                'commonname' => $row->common_name,
                'size' => (string)$row->tbl_sizes_idtbl_sizes,
                'sizecategory' => (string)$row->tbl_size_categories_idtbl_size_categories,
                'categoryName' => $row->categoryName,
                'productimagepath' => $row->productimagepath,
                'qty' => (string)$row->qty,
            ];
        });

        return response()->json($result, 200, [], JSON_UNESCAPED_SLASHES);
    }
}
