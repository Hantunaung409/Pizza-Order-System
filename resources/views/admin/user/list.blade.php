@extends('admin.layouts.master')

@section('title', 'User List Page')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">User List</h2>

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
                    <div class="row">
                        <div class="col-4">Total - ( {{ $users->total() }} )</div>
                    </div>
                    {{-- @if (count($adminList) != 0) --}}
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

                                @foreach ($users as $user)
                                    <tr class="tr-shadow my-2">
                                        <td class="col-2">
                                            @if ($user->image == null)
                                                @if ($user->gender == 'male')
                                                    <img src="{{ asset('image/default_user_profile.jpeg') }}"
                                                        alt="John Doe" />
                                                @else
                                                    <img src="{{ asset('image/female_default_user_profile.png') }}"
                                                        alt="John Doe" />
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $user->image) }}" class="shadow-sm" />
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->gender }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            <input type="hidden" name="" class="userId" value="{{ $user->id }}">
                                            <select name="" id="" class="form-control changeRole">
                                                <option value="user" @if ($user->role == 'user') selected @endif>
                                                    User</option>
                                                <option value="admin" @if ($user->role == 'admin') selected @endif>
                                                    Admin</option>
                                            </select>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin@deleteUser', $user->id) }}">
                                                <div class="table-data-feature">
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </div>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="">

                            {{-- {{ $adminList->links() }} --}}
                            {{ $users->appends(request()->query())->links() }}

                        </div>
                    </div>
                    {{-- @endif --}}

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
                $userId = $('.userId').val();

                $dataSource = {
                    'changeRole': $role,
                    'userId': $userId
                };
                $.ajax({
                    type: 'get',
                    url: '/admin/user/ajax/change/role',
                    data: $dataSource,
                    dataType: 'json',
                })
                window.location.href = "/admin/user/list";
            })
        })
    </script>
@endsection
