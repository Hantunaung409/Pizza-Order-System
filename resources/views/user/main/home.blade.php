@extends('user.layouts.master')

@section('content')
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="pr-3">Filter by
                        Categories</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class=" d-flex align-items-center justify-content-between mb-3 bg-dark text-white px-3 py-1">
                            {{-- <input type="checkbox" class="custom-control-input" checked id="price-all"> --}}
                            <label class=" mt-2" for="price-all">Categories</label>
                            <span class="badge border font-weight-normal">{{ count($category) }}</span>
                        </div>

                        <a href="{{ route('user@home') }}" class=" text-decoration-none">
                            <label class="" for="price-1">All</label>
                        </a>

                        @foreach ($category as $c)
                            <div class=" d-flex align-items-center justify-content-between mb-3 pt-1">
                                {{-- <input type="checkbox" class="custom-control-input" id="price-1"> --}}
                                <a href="{{ route('user@filter', $c->id) }}" class=" text-decoration-none">
                                    <label class="" for="price-1">{{ $c->name }}</label>
                                </a>

                                {{-- <span class="badge border font-weight-normal">150</span> --}}
                            </div>
                        @endforeach

                    </form>
                </div>
                <!-- Price End -->
                <div class="">
                    <button class="btn btn btn-warning w-100">Order</button>
                </div>
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="{{ route('user@cartList') }}">
                                  <button type="button" class="btn btn-sm btn-light position-relative">
                                    <i class="fa-solid fa-cart-shopping mr-2"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ count($cart) }}
                                    </span>
                                  </button>
                                </a>

                                <a href="{{ route('user@history') }}">
                                    <button type="button" class="btn btn-sm btn-light position-relative ml-4">
                                        <i class="fa-solid fa-clock-rotate-left mr-1"></i>History
                                      <span
                                          class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                          {{ count($history) }}
                                      </span>
                                    </button>
                                  </a>

                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    {{-- <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Sorting</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Ascending</a>
                                        <a class="dropdown-item" href="#">Descending</a>
                                    </div> --}}
                                    <select name="sorting" id="sortingOption" class="form-control ">
                                        <option value="desc">Descending</option>
                                        <option value="asc">Ascending</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" row" id="dataList">

                        @if (count($pizzas) != 0)
                            @foreach ($pizzas as $pizza)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" style="height: 220px;"
                                                src="{{ asset('storage/productsImage/' . $pizza->image) }}" alt="">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""><i
                                                        class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-outline-dark btn-square"
                                                    href="{{ route('user@pizzaDetails', $pizza->id) }}"><i
                                                        class="fa-solid fa-info"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate"
                                                href="">{{ $pizza->name }}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{ $pizza->price }}Kyats</h5>
                                                {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mb-1">
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class=" shadow-sm fs-1 text-center">There is no Product<i
                                    class="fa-solid fa-pizza-slice ms-4"></i></p>
                        @endif

                    </div>


                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            //    $.ajax({
            //     type : 'get',
            //     url : 'http://127.0.0.1:8000/user/ajax/pizza/list',
            //     dataType : 'json',
            //     success : function (response){
            //         console.log(response);
            //     }
            //    })

            $('#sortingOption').change(function() {
                $eventOption = $('#sortingOption').val();

                if ($eventOption == 'desc') {

                    $.ajax({
                        type: 'get',
                        url: '/user/ajax/pizza/list',
                        data: {
                            'status': 'desc'
                        },
                        dataType: 'json',
                        success: function(response) {
                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {
                                $list += `
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" style="height: 220px;"
                                            src="{{ asset('storage/productsImage/${response[$i].image}') }}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href=""><i
                                                    class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i
                                                    class="fa-solid fa-info"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate"
                                            href="">${response[$i].name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${response[$i].price}Kyats</h5>
                                            {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
            `;
                            }
                            $('#dataList').html($list);


                        }
                    })
                } else if ($eventOption == 'asc') {
                    $.ajax({
                        type: 'get',
                        url: '/user/ajax/pizza/list',
                        data: {
                            'status': 'asc'
                        },
                        dataType: 'json',
                        success: function(response) {
                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {
                                $list += `
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" style="height: 220px;"
                                            src="{{ asset('storage/productsImage/${response[$i].image}') }}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href=""><i
                                                    class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i
                                                    class="fa-solid fa-info"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate"
                                            href="">${response[$i].name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${response[$i].price}Kyats</h5>
                                            {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
            `;
                            }
                            $('#dataList').html($list);

                        }
                    })
                }

            })
        });
    </script>
@endsection
