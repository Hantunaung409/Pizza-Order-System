@extends('admin.layouts.master')

@section('title', 'Order List Page')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>
                    </div>
                    {{-- Search --}}
                    <div class="row">
                        <div class="col-4">
                            <h3>Total-({{ $order->total() }})&nbsp;Orders</h3>
                        </div>
                        <div class=" col-4 offset-4">
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

                    </div>
                    {{-- end Search --}}
                     <div class="row mt-4">
                        <div class="d-flex">
                         <label class=" mt-1 me-2 text-bolder">Order Status :</label>
                         <div class="col-2">
                        <form action="{{ route('order@SortWithStatus') }}" method="get">
                            @csrf
                         <select name="status" class="form-control">
                            <option value="">All..</option>
                            <option value="0" @if (request('status') == '0') selected @endif>Pending..</option>
                            <option value="1" @if (request('status') == '1') selected @endif>Accept..</option>
                            <option value="2" @if (request('status') == '2') selected @endif>Reject..</option>
                         </select>
                         </div>
                         <button class="btn btn-sm btn-dark text-white" type="submit">Sort</button>
                        </form>

                        </div>
                     </div>

                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Ordered Date</th>
                                <th>Order Code</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                          @foreach ($order as $o)
                          <tr class="tr-shadow my-2">
                    <input type="hidden" name="" class="orderId" value="{{ $o->id }}">
                            <td>{{ $o->user_id }}</td>
                            <td>{{ $o->user_name }}</td>
                            <td>{{ $o->created_at->format('j-F-Y') }}</td>
                            <td><a href="{{ route('order@listInfo',$o->order_code) }}" class=" text-decoration-none">{{ $o->order_code }}</a></td>
                            <td>{{ $o->total_price }}&nbsp;MMKs</td>
                            <td>
                                <select name="status" class="form-control changeStatus">
                                    <option value="0" @if ($o->status == 0) selected @endif>Pending..</option>
                                    <option value="1" @if ($o->status == 1) selected @endif>Accept..</option>
                                    <option value="2" @if ($o->status == 2) selected @endif>Reject..</option>
                                </select>
                            </td>
                        </tr>
                          @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5">
                        {{ $order->links() }}
                    </div>
                    <!-- END DATA TABLE -->
                </div>
                </div>
            </div>
        </div>
    @endsection
@section('scriptSource')
<script>
    $(document).ready(function (){
        // $('#orderStatus').change(function (){
        //     $status = $('#orderStatus').val();
        //     //ajax
        //     $.ajax({
        //         type : 'get',
        //         url : '/admin/order/ajax/orderList/status',
        //         data : {
        //             'status' : $status
        //         },
        //         dataType : 'json',
        //         success : function (response){
        //             $list = '';
        //               for ($i = 0; $i < response.data.length; $i++) {
        //                 $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        //                 $dbDate = new Date(response.data[$i].created_at);
        //                 $finalDate = $months[$dbDate.getMonth()]+"-"+$dbDate.getDate()+"-"+$dbDate.getFullYear();

        //                 if(response.data[$i].status == 0){
        //                     $statusMessage = `
        //                     <select name="status" class="form-control changeStatus">
        //                             <option value="0" selected >Pending..</option>
        //                             <option value="1" >Accept..</option>
        //                             <option value="2" >Reject..</option>
        //                         </select>
        //                     `;
        //                 }else if(response.data[$i].status == 1){
        //                     $statusMessage = `
        //                     <select name="status" class="form-control changeStatus">
        //                             <option value="0" >Pending..</option>
        //                             <option value="1" selected >Accept..</option>
        //                             <option value="2" >Reject..</option>
        //                         </select>
        //                     `;
        //                 }else if(response.data[$i].status == 2){
        //                     $statusMessage = `
        //                     <select name="status" class="form-control changeStatus">
        //                             <option value="0" >Pending..</option>
        //                             <option value="1" >Accept..</option>
        //                             <option value="2" selected >Reject..</option>
        //                         </select>
        //                     `;
        //                 }

        //                 $list += `
        //                 <tr class="tr-shadow my-2">
        //                     <input type="hidden" name="" class="orderId" value="${response.data[$i].id}">
        //                     <td>${ response.data[$i].user_id }</td>
        //                     <td>${ response.data[$i].user_name }</td>
        //                     <td>${ response.data[$i].created_at }->format('F-j-Y')</td>
        //                     <td>${ response.data[$i].order_code }</td>
        //                     <td>${ response.data[$i].total_price }&nbsp;MMKs</td>
        //                     <td>${ $statusMessage }</td>
        //                 </tr>
        //                          `;
        //              }
        //             //  date time format and conditional are different in jquery
        //             $('#dataList').html($list);
        //         }
        //     })
        // })

        //change status
        $('.changeStatus').change(function () {
            $currentStatus = $(this).val();
            $parentNode = $(this).parents("tr");
            $orderId = $parentNode.find('.orderId').val();

            $dataSource = {
              'status' : $currentStatus,
              'orderId' : $orderId
            };

            $.ajax({
                type : 'get',
                url :  '/admin/order/ajax/change/status',
                data :$dataSource,
                dataType :'json',
            })
            window.location.href = "/admin/order/list";
        })




    } )
</script>

@endsection
