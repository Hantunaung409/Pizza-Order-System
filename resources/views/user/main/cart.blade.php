@extends('user.layouts.master')
@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartList as $c)
                            <tr>
                                <input type="hidden" name="userId" class="userId" value="{{ $c->user_id }}">
                                <input type="hidden" name="productId" class="productId" value="{{ $c->product_id }}">
                                <input type="hidden" name="" value="{{ $c->productPrice }}" id="proPrice">
                                <input type="hidden" name="" class="orderId" value="{{ $c->id }}">
                                {{-- this is because we cant catch product price's value with the string --MMks-- --}}
                                <td>
                                    <img src="{{ asset('storage/productsImage/' . $c->product_image) }}"
                                        class=" img-thumbnail" alt="" style="width: 50px;">
                                </td>
                                <td class="align-middle">{{ $c->productName }}</td>
                                <td class="align-middle">{{ $c->productPrice }}MMKs</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm border-0 text-center"
                                            value="{{ $c->qty }}" id="qty">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle col-3" id="totalPrice">{{ $c->productPrice * $c->qty }}MMKs</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class=" pr-3">Cart Summary</span>
                </h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="summaryTotal">{{ $totalPrice }}MMKs</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">5000MMKs</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalPrice">{{ $totalPrice + 5000 }}MMKs</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="orderBtn">Proceed To
                            Checkout</button>

                        <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id="clearBtn">Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            //when plus button is clicked
            $('.btn-plus').click(function() {
                $parentNode = $(this).parents("tr");
                $price = $parentNode.find("#proPrice").val();
                $qty = Number($parentNode.find("#qty").val());
                //    catch click event with fa-plus and need to add 1 to $qty in lecture
                $total = $price * $qty;
                $parentNode.find("#totalPrice").html($total + "MMKs");

                //cannot seperate function cuz of $this
                summaryCalculation();
            })
            //when minus button is clicked
            $('.btn-minus').click(function() {
                $parentNode = $(this).parents("tr");
                $price = $parentNode.find("#proPrice").val();
                $qty = Number($parentNode.find("#qty").val());
                //    catch click event with fa-plus and need to add 1 to $qty in lecture
                $total = $price * $qty;
                $parentNode.find("#totalPrice").html($total + "MMKs");
                summaryCalculation();
            })
            //when cross button is clicked
            $('.btnRemove').click(function() {
                $parentNode = $(this).parents("tr");
                $orderId = $parentNode.find(".orderId").val();
                $productId = $parentNode.find(".productId").val();


                $.ajax({
                    type: 'get',
                    url: '/user/ajax/clear/row',
                    data: {
                        'orderId': $orderId,
                        'productId': $productId
                    },
                    dataType: 'json',
                })

                $parentNode.remove();
                summaryCalculation();
            })

            //summary calculation
            function summaryCalculation() {
                $summaryTotal = 0;
                $('#dataTable tr').each(function(index, row) {
                    $summaryTotal += Number($(row).find('#totalPrice').text().replace("MMKs", ""));
                });
                $('#summaryTotal').html(`${$summaryTotal} MMKs`);
                $('#finalPrice').html(`${$summaryTotal+5000} MMKs`);
            }

            //proceed to checkout

            $('#orderBtn').click(function() {
                $orderList = [];
                $random = Math.floor(Math.random() * 10000001);

                $('#dataTable tbody tr').each(function(index, row) {
                    $orderList.push({
                        'user_id': $(row).find('.userId').val(),
                        'product_id': $(row).find('.productId').val(),
                        'qty': $(row).find('#qty').val(),
                        'total': $(row).find('#totalPrice').text().replace('MMKs', '') * 1,
                        'order_code': "POS" + $random
                    });
                });
                //ajax
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/order',
                    data: Object.assign({}, $orderList),
                    // $orderList need to be object format
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == "true") {
                            window.location.href = "/user/homePage";
                        }
                    }
                })
            })
            //when clear button is clicked
            $('#clearBtn').click(function() {

                $('#dataTable tbody tr').remove();
                $('#summaryTotal').html("0 MMKs");
                $('#finalPrice').html("0 MMKs");

                $.ajax({
                    type: 'get',
                    url: '/user/ajax/clear/cart',
                    dataType: 'json'
                })

            })



        })
    </script>
@endsection
