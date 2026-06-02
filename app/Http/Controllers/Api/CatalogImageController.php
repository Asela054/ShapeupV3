<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerHoldstock;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CatalogImageController extends Controller
{
    /**
     * GET /api/getallcatalogimages
     */
    public function index()
    {
        try {
            $result = [];

            $rows = DB::table('tbl_product_image')
                ->leftJoin('tbl_catalog', 'tbl_catalog.idtbl_catalog', '=', 'tbl_product_image.tbl_catalog_idtbl_catalog')
                ->leftJoin('tbl_catalog_category', 'tbl_catalog_category.idtbl_catalog_category', '=', 'tbl_catalog.tbl_catalog_category_idtbl_catalog_category')
                ->select(
                    'tbl_product_image.idtbl_product_image as id',
                    'tbl_product_image.imagepath as path',
                    'tbl_product_image.tbl_catalog_idtbl_catalog as catalog_id',
                    'tbl_catalog_category.category as category',
                    'tbl_catalog_category.sequence as sequence'
                )
                ->where('tbl_catalog.status', 1)
                ->orderBy('tbl_catalog_category.sequence', 'asc')
                ->get();

            foreach ($rows as $row) {
                $catalogId = $row->catalog_id;
                $addToList = false;
                $maincategoryId = 0;
                $availableqty = 0;

                // Sum available qty per product in this catalog where stock > 0
                $stockRows = DB::select(
                    "SELECT SUM(s.qty) AS avialableqty, s.tbl_product_idtbl_product as productId
                     FROM tbl_catalog_details d
                     LEFT JOIN tbl_stock s ON d.product_name = s.tbl_product_idtbl_product
                     WHERE d.tbl_catalog_idtbl_catalog = ?
                     GROUP BY s.tbl_product_idtbl_product
                     HAVING avialableqty > 0",
                    [$catalogId]
                );

                foreach ($stockRows as $stockRow) {
                    $avialableqty = (int) ($stockRow->avialableqty ?? 0);
                    $productId = $stockRow->productId;

                    // Sum hold stock for this product
                    $hold = CustomerHoldstock::where('tbl_product_idtbl_product', $productId)
                        ->where('status', 1)
                        ->where('invoiceissue', 0)
                        ->select(DB::raw('COALESCE(SUM(qty),0) as qty'))
                        // ->groupBy('tbl_product_idtbl_product')
                        ->pluck('qty')
                        ->first() ?? 0;

                    // Get main category for product
                    $prodCat = Product::where('idtbl_product', $productId)
                    ->value('tbl_product_category_idtbl_product_category') ?? 0;

                    if (($avialableqty - (int)$hold) > 0) {
                        $addToList = true;
                        $maincategoryId = $prodCat;
                        $availableqty = $avialableqty;
                        
                    }
                }

                if ($addToList) {
                    $result[] = [
                        'id' => (string) $row->id,
                        'path' => $row->path,
                        'catalog_id' => (string) $catalogId,
                        'category' => $row->category,
                        'sequence' => (string) $row->sequence,
                        // 'maincategoryId' => (string) $maincategoryId,
                        // 'availableqty' => (string) $availableqty,
                    ];
                }
            }

            return response()->json($result);
        } catch (\Throwable $e) {
            Log::error('getallcatalogimages error: '.$e->getMessage(), ['exception' => $e]);
            return response()->json([], 500);
        }
    }
}
