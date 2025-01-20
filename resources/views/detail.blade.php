@extends('layouts.app')

@section('content')
<div class="container">
        <!-- <div class="item">
            <h2>商品情報詳細画面</h2>
            <p>ID</p><br>
            <p>商品画像</p><br>
            <p>商品名</p><br>
            <p>メーカー</p><br>
            <p>価格</p><br>
            <p>在庫数</p><br>
            <p>コメント</p><br>
        </div>
        <div class="content">
            <h2>　</h2><br>
            <p>{!! nl2br(htmlspecialchars($product->company_id)) !!}</p><br>
            <p>{!! nl2br(htmlspecialchars($product->img_path)) !!}</p><br>
            <p>{!! nl2br(htmlspecialchars($product->product_name)) !!}</p><br>
            <p>{!! nl2br(htmlspecialchars($product->company_name)) !!}</p><br>
            <p>{!! nl2br(htmlspecialchars($product->price)) !!}</p><br>
            <p>{!! nl2br(htmlspecialchars($product->stock)) !!}</p><br>
            <p>{!! nl2br(htmlspecialchars($product->comment)) !!}</p><br>
        </div>
        <div class="bottom">
            <a class="btn btn-success" href="{{ url('/edit') }}">編集</a>
            <a class="btn btn-success" href="{{ url('/products') }}">戻る</a>
        </div> -->

        
            <div class="row">
                <h2>商品情報詳細画面</h2>
                <div class="row mb-3">
                    <label class="col-form-label col-sm-2">ID</label>
                    <div class="col-sm-10">
                        {!! nl2br(htmlspecialchars($product->company_id)) !!}
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-form-label col-sm-2">商品画像</label>
                    <div class="col-sm-10">
                        {!! nl2br(htmlspecialchars($product->img_path)) !!}
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
        
</div>
@endsection