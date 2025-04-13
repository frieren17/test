@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品情報編集画面</h2>

    <form action="{{ route('show.update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="form-group">

                <div class="row mb-3">
                    <label class="col-form-label col-sm-2" for="company_id">ID</label>
                    <div class="col-sm-10">
                        {{$product->id}}
                    </div>
                </div>


                <div class="row mb-3">
                    <label class="col-form-label col-sm-2" for="product_name">商品名<span class="text-danger">*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="product_name" id="product_name" value="{{ $product->product_name }}">
                        @if($errors->has('product_name'))
                            <p>{{ $errors->first('product_name') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-sm-2" for="company_name">メーカー名<span class="text-danger">*</label>
                    <div class="col-sm-10">
                    <select class="form-control" id="id" name="company_name">
                        <option value="" selected>選択してください</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name}}</option>
                        @endforeach
                        </select>
                        @if($errors->has('company_name'))
                            <p>{{ $errors->first('company_name') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-sm-2" for="price">価格<span class="text-danger">*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="price" id="price" value="{{ $product->price }}">
                        @if($errors->has('price'))
                            <p>{{ $errors->first('price') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-sm-2" for="stock">在庫数<span class="text-danger">*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="stock" id="stock" value="{{ $product->stock }}">
                        @if($errors->has('stock'))
                            <p>{{ $errors->first('stock') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-sm-2" for="comment">コメント</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" style="height:100px" name="comment" id="comment">{{ $product->comment }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-sm-2" for="comment">商品画像</label>
                    <div class="col-sm-10">
                        <form action="{{ route('regist', ['id' => $product->id]) }}" method="POST" enctype='multipart/form-data'>
                            <input type="file" name="image">
                        </form>
                    </div>
                </div>

                <div class="col-12 mb-2 mt-2">
                    <button type="submit" class="btn btn-primary">更新</button>
                    <a class="btn btn-success" href="{{ url('/products') }}">戻る</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection