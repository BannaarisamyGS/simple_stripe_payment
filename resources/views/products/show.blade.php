@extends("layouts.app")

@section("content")
    <div class="container-fluid">
        <div class="row offset-1 col-4">
            @if(session('message'))
                <div class="alert alert-success" role="alert">{{ session('message') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif
        </div>
        <div class="row offset-2 col-9">
            @foreach ($products as $product)
            <div class="col-3">
                <img src="{{ route('productImage',basename($product->product_url)) }}" height="200px" width="200px"><br>
                <span>{{ $product->product_name }}</span><br>
                <a class="btn btn-primary" href="/product-purchase-page/{{ $product->id }}"> Buy Now</a>
            </div>    
            @endforeach
            
        </div>
    </div>
@endsection