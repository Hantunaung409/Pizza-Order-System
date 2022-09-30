@extends('admin.layouts.master')
@section('title', 'Message Detail Page')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12 shadow-lg">
                     <div class="card">

                        <div class="cart-title">
                            <div class=" col-1 mt-4">
                               <a href="{{ route('admin@messageListPage') }}" class="btn btn-dark text-white "> <i class="fa-solid fa-arrow-left "></i></a>
                            </div>
                            <div class=" col-2 offset-9">
                            <a href="{{ route('admin@messageDelete',$mDetail->id) }}" class="me-4">
                                <button class="item" data-toggle="tooltip"
                                    data-placement="top" title="Delete">
                                    <i class="zmdi zmdi-delete fs-1"></i>
                                </button>
                            </a>
                                <button class="item me-4" data-toggle="tooltip"
                                    data-placement="top" title="For-show-btn">
                                    <i class="fa-regular fa-envelope fs-1"></i>
                                </button>
                                <button class="item me-4" data-toggle="tooltip"
                                    data-placement="top" title="For-show-btn">
                                    <i class="fa-solid fa-file-arrow-down fs-1"></i>
                                </button>
                            </div>

                        </div>
                        <hr>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class=" mb-4"><i class="fa-regular fa-user mr-2"></i>{{ $mDetail->name }}</div>
                                    <div class=" mb-4">
                                @if ($mDetail->image == null)

                                    @if ($mDetail->user_gender == 'male')
                                        <img src="{{ asset('image/default_user_profile.jpeg') }}"
                                            alt="" class="image-thumbnail shadow-sm">
                                    @else
                                        <img src="{{ asset('image/female_default_user_profile.png') }}"
                                            alt="" class="image-thumbnail shadow-sm">
                                    @endif
                                @else
                                    <img src="{{ asset('storage/' .$mDetail->image) }}" alt="user Image"
                                        class="image-thumbnail shadow-sm">
                                @endif
                                    </div>
                                    <div class=" mb-4"><i class="fa-regular fa-envelope mr-2"></i>{{ $mDetail->email }}</div>
                                    <div class=" mb-4"><i class="fa-solid fa-phone mr-2"></i>{{ $mDetail->user_phone }}</div>
                                </div>
                                <div class="col-7 offset-1 border-left">
                                    <div class=" mb-5"><h3><i class="fa-regular fa-message mr-4"></i>Message</h3></div>
                                    <div class="container-lg shadow-sm" style=" height: 80%;">
                                        <p class=" m-4">{{ $mDetail->message }}</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>

                </div>
            </div>
        </div>
    </div>
@endsection

