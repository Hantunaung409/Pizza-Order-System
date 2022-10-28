@extends('admin.layouts.master')

@section('title', 'Category List Page')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Admin List</h2>

                            </div>
                        </div>
                    </div>

                    {{-- alert --}}

                    @if (session('accountDeleted'))
                        <div class="col-6 offset-6">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong><i class="fa-solid fa-trash"></i>{{ session('accountDeleted') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    {{-- end alert --}}

                    {{-- Search --}}
                    <div class="row">
                        <div class="col-4">
                            <h4>Results of <span class=" text-success">{{ request('key') }}</span></h4>
                        </div>
                        <div class=" col-4 offset-4">
                            <form action="{{ route('admin@listPage') }}" method="get">
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
                    {{-- <div class="row">
                                        <div class="col-4">Total - ( {{ $adminList->total() }} )</div>
                                     </div> --}}
                    {{-- end Search --}}

                    @if (count($adminList) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Phone Address</th>
                                        <th>Role</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($adminList as $admin)
                                                                               <tr class="tr-shadow my-2">
                                            <td class="col-2">
                                                @if ($admin->image == null)
                                                    @if ($admin->gender == 'male')
                                                        <img src="{{ asset('image/default_user_profile.jpeg') }}"
                                                            alt="" class="image-thumbnail shadow-sm">
                                                    @else
                                                        <img src="{{ asset('image/female_default_user_profile.png') }}"
                                                            alt="" class="image-thumbnail shadow-sm">
                                                    @endif
                                                @else
                                                    <img src="{{ asset('storage/' . $admin->image) }}" alt=""
                                                        class="image-thumbnail shadow-sm">
                                                @endif

                                            </td>
                                            <td class="desc">{{ $admin->name }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->gender }}</td>
                                            <td>{{ $admin->phone }}</td>
                                            <td>
                                                @if (Auth::user()->id != $admin->id)
                                                    <select name="" id=""
                                                        class="form-control mr-3 changeRole">
                                                        <option value="admin">Admin</option>
                                                        <option value="user">User</option>
                                                    </select>
                                                @endif

                                            </td>
                                            <td>
                                                @if (Auth::user()->id != $admin->id)
                                                    <div class="table-data-feature">
                                                        <a href=" @if (Auth::user()->id == $admin->id) #  @else {{ route('admin@delete', $admin->id) }} @endif "
                                                            class=" me-1">
                                                            <button class="item" data-toggle="tooltip"
                                                                data-placement="top" title="Delete">
                                                                <i class="zmdi zmdi-delete"></i>
                                                            </button>
                                                            <input type="hidden" name="" class="adminId"
                                                                value="{{ $admin->id }}">
                                                        </a>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>

                                    @endforeach

                                </tbody>
                            </table>
                            <div class="">

                                {{-- {{ $adminList->links() }} --}}
                                {{ $adminList->appends(request()->query())->links() }}

                            </div>
                        </div>
                    @endif

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('.changeRole').change(function() {
                $role = $(this).val();
                $adminId = $('.adminId').val();

                $dataSource = {
                    'changeRole': $role,
                    'adminId': $adminId
                };
                $.ajax({
                    type: 'get',
                    url: '/admin/ajax/changeRole',
                    data: $dataSource,
                    dataType: 'json',
                })
                window.location.href = "/admin/listPage";
            })
        })
    </script>
@endsection
