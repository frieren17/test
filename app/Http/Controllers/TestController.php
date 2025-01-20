<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    // public function showListProduct() {
    //     $test_product = new Product();
    //     $products = $test_product->getList();

    //     return view('testview',['products' => $products]);
    // }

    // public function showListCompany() {
    //     $test_company = new Company();
    //     $companies = $test_company->getList();

    //     return view('testview', ['companies' => $companies]);
    // }

    public function showRegistForm() {
        return view('productregister');
    }

    
    
    public function testView(Request $request) {
        // $this->products = new Product();
        // dd($this->products);
        // $results = $this->products->getUserNameById();
        // dd($results);

        $keyword = $request->input('keyword');
        $selectedCompanyId = $request->input('company_name');

        $query = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name as company_name');
        if(!empty($keyword)) {
            $query->where('products.product_name', 'LIKE', "%{$keyword}%");
        }
        if (!empty($selectedCompanyId)) {
            $query->where('products.company_id', '=', $selectedCompanyId);
        }
        $products = $query->get();
        $companies = DB::table('companies')->get();

            
        return view('testView', compact('products', 'keyword', 'companies', 'selectedCompanyId'));
        
    }


    public function destroy($id) {
        DB::table('products')->where('products.id', $id)->delete();
        
       return redirect()->route('show.test');
    }

    public function showListDetail($id) {
        $product = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name as company_name')
            ->where('products.id', '=', $id)
            ->first();
        return view('detail',['product' => $product]);
    }


    public function showRegister() {
        return view('productregister');
    }

    public function addition(Request $request) {
        // $productregist = DB::table('products')
        //     ->join('companies', 'products.company_id', '=', 'companies.id')
        //     ->select('products.*', 'companies.company_name as company_name')
        //     ->first();
        // $productregist->product_name = $request->input(["product_name"]);
        // $productregist->company_name = $request->input(["company_name"]);
        // $productregist->price = $request->input(["price"]);
        // $productregist->stock = $request->input(["stock"]);
        // $productregist->comment = $request->input(["comment"]);
        // return redirect()->route('show.addition');

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
        ]);

        $company = DB::table('companies')
            ->where('company_name', $request->input('company_name'))
            ->first();

        //if (!$company) {
            //return redirect()->route('show.addition')->with('error', '指定された会社名が存在しません');
        //}

        DB::table('products')->insert([
            'product_name' => $request->input('product_name'),
            'company_id' => $request->input('company_name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'comment' => $request->input('comment'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('show.addition')->with('success', '商品が正常に登録されました');
    }

    public function create(Request $request) {
        $companies = DB::table('companies')->get();
        return view('productregister', ['companies' => $companies]);
    }

    public function edit($id) {
        $product = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name as company_name')
        ->where('products.id', '=', $id)
        ->first();
        $companies = DB::table('companies')->get();
        return view('edit',['product' => $product, 'companies' => $companies]);
    }


    public function update(Request $request, $id) {

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_name' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
        ]);

        $updated = DB::table('products')
            ->where('id', $id)
            ->update([
            'product_name' => $request->input('product_name'),
            'company_id' => $request->input('company_name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'comment' => $request->input('comment'),
            'updated_at' => now(),
        ]);

        return redirect()->route('show.detail', ['id' => $id])->with('success', '商品が正常に登録されました');
        
        
    }
   
    
}
