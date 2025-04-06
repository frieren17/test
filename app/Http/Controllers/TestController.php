<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\TestRequest;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function showRegistForm() {
        return view('productregister');
    }
    
    public function testView(Request $request) {
        $keyword = $request->input('keyword');
        $selectedCompanyId = $request->input('company_name');

        // Productモデルをインスタンス化
        $productModel = new Product();

        // インスタンスメソッドを呼び出す
        $products = $productModel->searchProducts($keyword, $selectedCompanyId);

        // 会社のデータを取得
        $companyModel = new Company(); 
        $companies = $companyModel->viewTest($request);

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

        $image = $request->file('image');

        $image_path = null;
        if($image) {
            $file_name = $image->getClientOriginalName();
            $image->storeAs('public/images', $file_name);
            $image_path = 'storage/images/' . $file_name;
        }

        $model = new Product();
        DB::beginTransaction();
    
        try {
             // 登録処理2we3
            $model->storeProduct($request, $image_path);
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

        $image = $request->file('image');
        $image_path = null;

        if ($image) {
            $file_name = $image->getClientOriginalName();
            $image->storeAs('public/images', $file_name);
            $image_path = 'storage/images/' . $file_name;  // 画像パス
        }

        $updated = $updateModel->updateProduct($request, $id, $image_path);

        return redirect()->route('show.detail', ['id' => $id])->with('success', '商品が正常に登録されました');
        
        
    }

    public function imageRegist(Request $request, $id, $image_path) {
        $productModel = new Product();
        DB::beginTransaction();
        try {
            $productModel->registImage($image_path);
            DB::commit();
            return back()->with('success', '画像が登録されました');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', '画像の登録に失敗しました');
        }
    }

    public function registSubmit(TestRequest $request) {
        $validatedData = $request->validated();
        DB::beginTransaction();
        try {
            $modelRequest = new Product();
            $modelRequest->submitRegist($request);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return back();
        }
        return redirect()->route('show.register');
    }
    
}
