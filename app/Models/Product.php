<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    // public function getList() {
    //     $model_products = DB::table('products')->get();

    //     return $model_products;
    // }

    // public function getUserNameById() {
    //     return DB::table('products')
    //         ->join('companies', 'products.company_id', '=', 'companies.id')
    //         ->get();
    // }

    protected $table = 'products'; // テーブル名←エロクワント

    public function searchProducts($keyword, $selectedCompanyId)
    {
        $query = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name as company_name');

        if (!empty($keyword)) {
            $query->where('products.product_name', 'LIKE', "%{$keyword}%");
        }

        if (!empty($selectedCompanyId)) {
            $query->where('products.company_id', '=', $selectedCompanyId);
        }

        return $query->get();
    }

    public function storeProduct($request) {
        DB::table('products')->insert([
            'product_name' => $request->input('product_name'),
            'company_id' => $request->input('company_name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'comment' => $request->input('comment'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }


    public function deleteProduct($id) {
        return DB::table('products')->where('products.id', $id)->delete();
    }

    public function getDetail($id) {
        return DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name as company_name')
        ->where('products.id', '=', $id)
        ->first();
    }

    public function getEdit($id) {
        return DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name as company_name')
        ->where('products.id', '=', $id)
        ->first();
    }

    public function updateProduct($request, $id) {
        return DB::table('products')
        ->where('id', $id)
        ->update([
        'product_name' => $request->input('product_name'),
        'company_id' => $request->input('company_name'),
        'price' => $request->input('price'),
        'stock' => $request->input('stock'),
        'comment' => $request->input('comment'),
        'updated_at' => now(),
        ]);
    }

    public function registImage($request) {
        DB::table('products')->insert([
            'img_path' => $image_path,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
