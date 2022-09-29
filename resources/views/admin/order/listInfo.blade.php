@extends('admin.layouts.master')

@section('title', 'Order List Page')

@section('content')

    <div class="main-content">
        <div class="section__content section__content--p30">
            <span class=" btn btn-sm btn-dark text-white mb-2" onclick="history.back()"> <i class="fa-solid fa-arrow-left"></i></span>
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    {{-- Search --}}
                    {{-- <div class="row">
                        <div class=" col-4 offset-8">
                            <form action="{{ route('order@list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" id="" class=" form-control"
                                        value="{{ request('key') }}">
                                    <button class=" btn btn-dark text-white"><i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div> --}}
                    {{-- end Search --}}
                <div class="table-responsive table-responsive-data2">
                    {{-- mini tabel for customer info --}}
                    <div class="row col-6">
                        <div class="card mt-4">
                            <div class="card-body " style=" border-bottom: 1px solid black;">
                                <h3><i class="fa-solid fa-clipboard mr-3"></i>Order List Info</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-regular fa-user mr-2"></i>Name</div>
                                    <div class="col">{{ strtoupper($orderList[0]->user_name) }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-solid fa-barcode mr-2"></i>Order Code</div>
                                    <div class="col">{{ $orderList[0]->order_code }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-regular fa-clock mr-2"></i>Order Date</div>
                                    <div class="col">{{ $orderList[0]->created_at->format('j-m-Y') }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-solid fa-money-check-dollar mr-2"></i>Total Price</div>
                                    <div class="col">{{ $order->total_price }}&nbsp;MMKs<small class=" text-danger">(With delivery fees)</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end of mini table for customer info --}}
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Product Id</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($orderList as $o)
                          <tr class="tr-shadow my-2">
                            <td></td>
                            <td>{{ $o->product_id }}</td>
                            <td class=" col-2"><img src="{{ asset('storage/productsImage/'.$o->product_image) }}" alt="" class=" img-thumbnail"></td>
                            <td>{{ $o->product_name }}</td>
                            <td>{{ $o->qty }}</td>
                            <td>{{ $o->total}}</td>
                        </tr>
                          @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5">
                        {{-- {{ $order->links() }} --}}
                    </div>
                    <!-- END DATA TABLE -->
                </div>
                </div>
            </div>
        </div>
    @endsection
