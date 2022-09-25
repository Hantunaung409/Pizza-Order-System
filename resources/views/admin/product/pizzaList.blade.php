@extends('admin.layouts.master')

@section('title', 'Products List Page')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Products List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('products@createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Products
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>
                    {{-- Search --}}
                    <div class="row">
                        <div class="col-4">
                            <h3>Total-({{ $pizzas->total() }})&nbsp;Products</h3>
                        </div>
                        <div class=" col-4 offset-4">
                            <form action="{{ route('products@list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" id="" class=" form-control"
                                        value="{{ request('key') }}">
                                    <button class=" btn btn-dark text-white"><i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                    {{-- end Search --}}

                    {{-- message --}}
                    @if (session('productDelete'))
                    <div class="col-6 offset-3 mt-5">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><i class="fa-solid fa-check"></i>{{ session('productDelete') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>
                @endif
                    {{-- end of message --}}

                @if (count($pizzas) != 0)
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Waiting Time</th>
                                <th>Total Viewed</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($pizzas as $piz)
                          <tr class="tr-shadow my-2">
                            <td>{{ $piz->category_name }}</td>
                            <td class=" col-2"><img src="{{ asset('storage/productsImage/'. $piz->image) }}" alt=""></td>
                            <td>{{ $piz->name }}</td>
                            <td>{{ $piz->price }}</td>
                            <td>{{ $piz->waiting_time }} <span class="text-muted">Minutes</span></td>
                            <td>{{ $piz->view_count }} <span class=" text-muted">Times</span></td>


                            <td>
                                <div class="table-data-feature">
                                    <a href="{{ route('products@details',$piz->id) }}">
                                     <button class="item" data-toggle="tooltip" data-placement="top"
                                        title="More">
                                        <i class="zmdi zmdi-more"></i>
                                    </button></a>


                                    <a href="{{ route('products@editPage',$piz->id) }}">
                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                        title="Edit">
                                        <i class="zmdi zmdi-edit"></i>
                                    </button>

                                    </a>

                                    <a href="{{ route('products@delete',$piz->id)}}">
                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                            title="Delete">
                                            <i class="zmdi zmdi-delete"></i>
                                        </button>
                                    </a>


                                </div>
                            </td>


                        </tr>
                          @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5">
                        {{ $pizzas->links() }}
                    </div>
                    <!-- END DATA TABLE -->
                </div>
                @else
                <h3>No results!</h3>
                @endif
                </div>
            </div>
        </div>
    @endsection
