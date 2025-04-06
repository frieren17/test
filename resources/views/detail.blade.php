@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
    <h2>商品情報詳細画面</h2>
    <div class="row mb-3">
        <label class="col-form-label col-sm-2">ID</label>
        <div class="col-sm-10">
            {!! nl2br(htmlspecialchars($product->id)) !!}
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-form-label col-sm-2">商品画像</label>
        <div class="col-sm-10">
            <img src="{{ asset($product->img_path) }}" style="max-width: 200px; max-height: 200px;">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-form-label col-sm-2">商品名</label>
        <div class="col-sm-10">
            {!! nl2br(htmlspecialchars($product->product_name)) !!}
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-form-label col-sm-2">メーカー</label>
        <div class="col-sm-10">
            {!! nl2br(htmlspecialchars($product->company_name)) !!}
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-form-label col-sm-2">価格</label>
        <div class="col-sm-10">
            {!! nl2br(htmlspecialchars($product->price)) !!}
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-form-label col-sm-2">在庫数</label>
        <div class="col-sm-10">
            {!! nl2br(htmlspecialchars($product->stock)) !!}
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-form-label col-sm-2">コメント</label>
        <div class="col-sm-10">
            {!! nl2br(htmlspecialchars($product->comment)) !!}
        </div>
    </div>

    <div class="col-12 mb-2 mt-2">
        <button type="submit" class="btn btn-primary" onclick="location.href='{{ route('show.edit',['id' =>$product->id]) }}' ">編集</button>
        <a class="btn btn-success" href="{{ url('/products') }}">戻る</a>
    </div>
</div>
@endsection