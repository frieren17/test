<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Sale extends Model
{
    protected $table = 'sales';

    public function purchaseProduct($productId)
    {
        // トランザクション開始
        return DB::transaction(function () use ($productId) {

            // 商品を取得（ロックして同時更新防止）
            $product = DB::table('products')->where('id', $productId)->lockForUpdate()->first();

            if (!$product) {
                return ['error' => '商品が見つかりません', 'status' => 404];
            }

            if ($product->stock < 1) {
                return ['error' => '在庫が不足しています', 'status' => 400];
            }

            // 在庫を更新
            DB::table('products')
                ->where('id', $productId)
                ->update(['stock' => DB::raw('stock - 1')]);

            // 売上を記録
            DB::table('sales')->insert([
                'product_id' => $productId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return ['success' => true];
        });
    }

}
