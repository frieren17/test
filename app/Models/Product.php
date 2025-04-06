<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'products'; 

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

    public function storeProduct($request, $image_path) {
        DB::table('products')->insert([
            'product_name' => $request->input('product_name'),
            'company_id' => $request->input('company_name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'comment' => $request->input('comment'),
            'img_path' => $image_path,
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

    public function updateProduct($request, $id, $image_path) {
        return DB::table('products')
        ->where('id', $id)
        ->update([
        'product_name' => $request->input('product_name'),
        'company_id' => $request->input('company_name'),
        'price' => $request->input('price'),
        'stock' => $request->input('stock'),
        'comment' => $request->input('comment'),
        'img_path' => $image_path,
        'created_at' => now(),
        'updated_at' => now(),
        ]);
    }

    public function submitRegist($data) {
        return DB::table('products')->insert([
            'product_name' => $data->product_name,
            'company_id' => $data->company_id,
            'price' => $data->price,
            'stock' => $data->stock,
            'comment' => $data->comment,
            'img_path' => $data->img_path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
