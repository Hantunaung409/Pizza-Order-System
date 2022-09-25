@extends('admin.layouts.master')

@section('title','Products create Page')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">

        <div class="container-fluid">
            <div class="row">
                <div class="col-3 offset-8">
                    <a href="{{ route('products@list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
                </div>
            </div>
            <div class="col-lg-6 offset-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Product Form</h3>
                        </div>
                        <hr>
                        <form action="{{ route('products@create') }}" method="post" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="control-label mb-1">Name</label>
                                <input id="name" name="name" type="text" class="form-control @error('name')    is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Product Name..." value="{{ old('name') }}" >
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="categoryName" class="control-label mb-1">Category</label>
                                <select name="categoryName" id="categoryName" class="form-control @error('categoryName')    is-invalid @enderror">
                                    <option value="">Choose Your Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('categoryName')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>

                            <div class="form-group">
                                <label for="desc" class="control-label mb-1">Description</label>
                                <textarea name="desc" id="desc" cols="30" rows="10" class="form-control @error('desc')    is-invalid @enderror" placeholder="Your description here ..." >{{ old('desc') }}</textarea>
                                @error('desc')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>

                            <div class="form-group">
                                <label for="image" class="control-label mb-1">Image</label>
                                <input type="file" name="image" id="image" class="form-control @error('image')    is-invalid @enderror" >
                                @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>

                            <div class="form-group">
                                <label for="price" class="control-label mb-1">Price</label>
                                <input id="price" name="price" type="number" class="form-control @error('price')    is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Price..." value="{{ old('price') }}">
                                @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>

                            <div class="form-group">
                                <label for="waitingTime" class="control-label mb-1">Waiting Time</label>
                                <input id="waitingTime" name="waitingTime" type="number" class="form-control @error('waitingTime')    is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Waiting Time..." value="{{ old('waitingTime') }}">
                                @error('waitingTime')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>

                            <div>
                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                    <span id="payment-button-amount">Add</span>
                                    {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                    <i class="fa-solid fa-circle-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
