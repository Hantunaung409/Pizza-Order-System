@extends('admin.layouts.master')

@section('title', 'Products Edit Page')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">

            <div class="container-fluid">
                <div class="col-3 offset-8">
                    <a href="{{ route('products@list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
                </div>
            </div>
            <div class="col-lg-6 offset-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class=" col-1">
                                <i class="fa-solid fa-arrow-left btn btn-dark text-white" onclick=" history.back()"></i>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Product Form</h3>
                                <small class=" text-muted">Last Update at-{{ $pizzas->created_at->format('d-m-Y') }}</small>
                            </div>
                            <hr>
                            <form action="{{ route('products@edit',$pizzas->id) }}" method="post" novalidate="novalidate"
                                enctype="multipart/form-data">
                                @csrf
                              <input type="hidden" name="pizzaID" value="{{ $pizzas->id }}">

                                <div class="form-group">
                                    <img src="{{ asset('storage/productsImage/' . $pizzas->image) }}" alt=""
                                        class=" shadow-sm col-12" style="height: 400px;">
                                    <input type="file" name="image" id="image"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="name" class="control-label mb-1">Name</label>
                                    <input id="name" name="name" type="text"
                                        class="form-control @error('name')    is-invalid @enderror" aria-required="true"
                                        aria-invalid="false" value="{{ old('name',$pizzas->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="categoryName" class="control-label mb-1">Category</label>
                                    {{-- <select name="categoryName" id="categoryName" class="form-control">
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @foreach ($categories as $cate)
                                            <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                        @endforeach
                                    </select>
                                     --}}
                                <select name="categoryName" id="categoryName" class="form-control">
                                    @foreach ($categories as $cate)
                                        <option value="{{ $cate->id }}" @if($cate->id == $pizzas->category_id) selected @endif>{{ $cate->name }}</option>
                                    @endforeach
                                </select>
                                </div>

                                <div class="form-group">
                                    <label for="desc" class="control-label mb-1">Description</label>
                                    <textarea name="desc" id="desc" cols="30" rows="10"
                                        class="form-control @error('desc')    is-invalid @enderror">{{ old('desc',$pizzas->description) }}</textarea>
                                    @error('desc')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="price" class="control-label mb-1">Price</label>
                                    <input id="price" name="price" type="number"
                                        class="form-control @error('price')    is-invalid @enderror" aria-required="true"
                                        aria-invalid="false" value="{{ old('price',$pizzas->price) }}">
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="waitingTime" class="control-label mb-1">Waiting Time</label>
                                    <input id="waitingTime" name="waitingTime" type="number"
                                        class="form-control @error('waitingTime')    is-invalid @enderror"
                                        aria-required="true" aria-invalid="false" value="{{ old('waitingTime',$pizzas->waiting_time) }}">
                                    @error('waitingTime')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class=" float-right">
                                     <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        Update
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
