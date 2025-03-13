<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    // 12～24行目は無視↓
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
        // 32～35行目は無視↓
        // $this->products = new Product();
        // dd($this->products);
        // $results = $this->products->getUserNameById();
        // dd($results);

        // $keyword = $request->input('keyword');
        // $selectedCompanyId = $request->input('company_name');
        

        // $query = DB::table('products')
        //     ->join('companies', 'products.company_id', '=', 'companies.id')
        //     ->select('products.*', 'companies.company_name as company_name');
        // if(!empty($keyword)) {
        //     $query->where('products.product_name', 'LIKE', "%{$keyword}%");
        // }
        // if (!empty($selectedCompanyId)) {
        //     $query->where('products.company_id', '=', $selectedCompanyId);
        // }
        // $products = $query->get();
        // $companies = DB::table('companies')->get();
        // return view('testView', compact('products', 'keyword', 'companies', 'selectedCompanyId'));
        
        $keyword = $request->input('keyword');
        $selectedCompanyId = $request->input('company_name');

        // Productモデルをインスタンス化
        $productModel = new Product();

        // インスタンスメソッドを呼び出す
        $products = $productModel->searchProducts($keyword, $selectedCompanyId);

        // 会社のデータを取得
        $companies = DB::table('companies')->get(); 

        return view('testView', compact('products', 'keyword', 'companies', 'selectedCompanyId'));
    }

    public function destroy($id) {
        $productModel = new Product();
        DB::beginTransaction();
    
        try {
             // 登録処理
            $productModel->deleteProduct($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
        return redirect()->route('show.test');
    }

    public function showListDetail($id) {
        $productModel = new Product();
        $product = $productModel->getDetail($id);
        return view('detail',['product' => $product]);
    }

    public function showRegister() {
        return view('productregister');
    }

    public function addition(Request $request) {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'img_path' => [
                'image',
                'max:1024',
                'mimes:jpg,png',
            ],
        ]);

        $model = new Product();
        DB::beginTransaction();
    
        try {
             // 登録処理2we3
            $model->storeProduct($request);
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
        
        return redirect()->route('show.addition')->with('success', '商品が正常に登録されました');
    }

    public function create(Request $request) {
        $companies = DB::table('companies')->get();
        return view('productregister', ['companies' => $companies]);
    }

    public function edit($id) {
        // $product = DB::table('products')
        // ->join('companies', 'products.company_id', '=', 'companies.id')
        // ->select('products.*', 'companies.company_name as company_name')
        // ->where('products.id', '=', $id)
        // ->first();
        $productModel = new Product();
        $companies = DB::table('companies')->get();
        DB::beginTransaction();
    
        try {
             // 登録処理
            $product = $productModel->getEdit($id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
        return view('edit',['product' => $product, 'companies' => $companies]);
    }


    //↓未修正
    public function update(Request $request, $id) {

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_name' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'img_path' => [
                'image',
                'max:1024',
                'mimes:jpg,png',
            ],
        ]);

        $updateModel = new Product();
        $updated = $updateModel->updateProduct($request, $id);

        // $updated = DB::table('products')
        //     ->where('id', $id)
        //     ->update([
        //     'product_name' => $request->input('product_name'),
        //     'company_id' => $request->input('company_name'),
        //     'price' => $request->input('price'),
        //     'stock' => $request->input('stock'),
        //     'comment' => $request->input('comment'),
        //     'updated_at' => now(),
        // ]);

        return redirect()->route('show.detail', ['id' => $id])->with('success', '商品が正常に登録されました');
        
        
    }


    public function imageRegist(Request $request) {
        $image = $request->file('image');
        if (!$image) {
            return back()->with('error', '画像が選択されていません');
        }
        $file_name = $image->getClientOriginalName();
        $image->storeAs('public/images', $file_name);
        $image_path = 'storage/images/' . $file_name;
        $image_path->save();

        \Log::info("画像パス: " . $image_path);

        $productModel = new Product();
        DB::beginTransaction();
        try {
            $productModel->registImage($image_path);
            DB::commit();
            return back()->with('success', '画像が登録されました');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error', '画像の登録に失敗しました');
        }
    }
}
