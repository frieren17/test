@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="links">
            <h2>商品一覧画面</h2>
            <div class="container-fluid">
                <div class="row">
                    <div class="col my-box">
                        <form action="{{ route('show.test') }}" method="GET" class="form-inline">
                        <input type="text" name="keyword" value="{{ $keyword }}" placeholder="検索キーワード" class="form-control">
                    </div>
                    <div class="col my-box">
                        <select class="form-control" id="id" name="company_name">
                            <option value="">メーカー名</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" {{ $company->id == $selectedCompanyId ? 'selected' : '' }}>
                                    {{ $company->company_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col my-box">
                        <input type="submit" value="検索" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>メーカー名</th>
                        <th><a class="btn btn-success" href="{{ route('show.register') }}">新規登録</a></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @if ($product->img_path)
                                <img src="{{ asset($product->img_path) }}" alt="Product Image" style="max-width: 200px; max-height: 200px;">
                            @else
                                <span>商品画像</span>
                            @endif
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>￥{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->company_name }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="location.href='{{ route('show.detail',['id' =>$product->id]) }}' ">
                            {{ __('詳細') }}
                            </button>
                        </td>
                        <td>
                            <form action="{{ route('id.destroy', ['id'=>$product->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>

            

        </div>
    </div>
</div>

@endsection