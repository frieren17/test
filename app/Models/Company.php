<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    // 11～15行目は無視↓
    // public function getList() {
    //     $model_companies = DB::table('companies')->get();

    //     return $model_companies;
    // }

    protected $table = 'companies';

}