<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Company;
use App\Models\Sale;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $productId = $request->input('product_id');

        DB::beginTransaction();
        try{
            $sale = new Sale();
            $result = $sale->purchaseProduct($productId);
            if (isset($result['error'])) {
                DB::rollBack();
                return response()->json(['message' => $result['error']], $result['status']);
            }
            DB::commit(); 
            return response()->json(['message' => '購入成功']);
        } catch (\Exception $e) {
            DB::rollBack(); 

            return response()->json([
                'message' => '購入処理中にエラーが発生しました。',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
