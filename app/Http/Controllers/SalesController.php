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
            'quantity' => 'nullable|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // Saleモデルのインスタンスを生成
        $sale = new Sale();

        // 在庫更新処理（モデル内）
        $result = $sale->purchaseProduct($productId, $quantity);

        if (isset($result['error'])) {
            return response()->json(['message' => $result['error']], $result['status']);
        }

        return response()->json(['message' => '購入成功']);
    }
}
