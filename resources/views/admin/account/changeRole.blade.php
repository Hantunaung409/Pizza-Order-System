@extends('admin.layouts.master')

@section('title', 'Edit Account Details')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">

            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class=" col-1">
                                <i class="fa-solid fa-arrow-left btn btn-dark text-white" onclick=" history.back()"></i>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Your Account Details</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <form action="{{ route('admin@changeRole',$account->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="" class="userId" value="{{ $account->id }}">
                                    <div class="row">
                                        <div class=" col-3 offset-1">
                                            @if ($account->image == null)
                                            @if ($account->gender == "male")
                                            <img src="{{ asset('image/default_user_profile.jpeg') }}" alt="John Doe" />
                                            @else
                                            <img src="{{ asset('image/female_default_user_profile.png') }}" alt="John Doe" />
                                            @endif
                                            @else
                                                <img src="{{ asset('storage/'.$account->image) }}"
                                                    class="shadow-sm" />
                                            @endif

                                            <input type="file" name="image" id="image" class="form-control @error('image')  is-invalid @enderror" disabled>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-8">

                                            <label for="name">Name:</label>
                                            <input disabled type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name', $account->name) }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            <label for="role">Role</label>
                                                <select name="role" id="" class=" form-control role">
                                                   <option value="admin" @if ($account->role == "admin")
                                                       selected
                                                   @endif>Admin</option>
                                                   <option value="user" @if ($account->role == "user")
                                                       selected
                                                   @endif>User</option>
                                            </select>

                                            <label for="email">Email:</label>
                                            <input disabled type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', $account->email) }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            <label for="phone">Phone:</label>
                                            <input disabled type="number" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone', $account->phone) }}">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            <label for="address">Address:</label>
                                            <input disabled type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                                                value="{{ old('address', $account->address) }}">
                                                @error('address')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                                <label for="gender">Gender:</label>
                                                 <select name="gender" id="gender" class=" form-control" disabled>
                                                    <option value="male" @if ($account->gender == 'male') selected  @endif>Male</option>
                                                    <option value="female" @if ($account->gender == 'female') selected @endif>Female</option>
                                                 </select>
                                            <label for="createdAt">Latest Updated at:</label>
                                            <input disabled type="text" name="createdAt" id="createdAt" class="form-control"
                                                value="{{ old('createdAt', $account->created_at->format('j-F-Y')) }}">

                                            <button class=" btn btn-dark float-end mt-3"><i
                                                    class="fa-regular fa-circle-right me-2"></i>Save
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


