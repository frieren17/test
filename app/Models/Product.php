<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    public function getList() {
        $model_products = DB::table('products')->get();

        return $model_products;
    }

    public function getUserNameById() {
        return DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->get();
    }


    

}
