@extends('admin.layouts.master')

@section('title','Products Details')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">

        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                     <div class="row">
                        <i class="fa-solid fa-arrow-left" onclick="history.back()"></i>
                     </div>
                     <div class="row">
                        <div class=" col-3 offset-2">
                            <img src="{{ asset('storage/productsImage/' . $pizza->image) }}" alt="">
                        </div>
                        <div class=" col-7">
                          <div class="my-2 btn btn-danger text-white w-25 fs-5 d-block"> {{ $pizza->name }} </div>
                          <span class="my2 btn btn-dark text-white"> <i class="fa-solid fa-money-check-dollar"></i>  {{ $pizza->price }}MMKs</span>
                          <span class="my2 btn btn-dark text-white"> <i class="fa-regular fa-clock"></i>  {{$pizza->waiting_time}}</span>
                          <span class="my2 btn btn-dark text-white"> <i class="fa-solid fa-eye"></i> {{ $pizza->view_count }}</span>
                          <span class="my2 btn btn-dark text-white"> <i class="fa-solid fa-calendar-days"></i>  {{ $pizza->category_name}}</span>
                          <span class="my2 btn btn-dark text-white"> <i class="fa-solid fa-calendar-days"></i>  {{ $pizza->created_at}}</span>
                          <div class="my-4"><i class="fa-solid fs-4 fa-file-lines me-2 "></i>Details</div>
                          <div class="">{{ $pizza->description }}</div>
                        </div>
                     </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
