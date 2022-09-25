@extends('user.layouts.master')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">

        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Edit Your Account Details</h3>
                        </div>
                                                {{-- updated success message --}}
                                                @if (session('updateSuccess'))
                                                <div class="col-6 offset-3">
                                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <strong><i class="fa-solid fa-check"></i>{{ session('updateSuccess') }}</strong>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                </div>
                                            @endif
                        <hr>
                        <div class="row">
                            <form action="{{ route('user@changeProfile',Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class=" col-3 offset-1">
                                        @if (Auth::user()->image == null)
                                        @if (Auth::user()->gender == "male")
                                        <img src="{{ asset('image/default_user_profile.jpeg') }}" alt="John Doe" />
                                        @else
                                        <img src="{{ asset('image/female_default_user_profile.png') }}" alt="John Doe" />
                                        @endif
                                        @else
                                            <img src="{{ asset('storage/'.Auth::user()->image) }}"
                                                class="shadow-sm" />
                                        @endif

                                        <input type="file" name="image" id="image" class="form-control mt-2 @error('image')  is-invalid @enderror">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-8">

                                        <label for="name">Name:</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', Auth::user()->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        <label for="email">Email:</label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', Auth::user()->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        <label for="phone">Phone:</label>
                                        <input type="number" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', Auth::user()->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        <label for="address">Address:</label>
                                        <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address', Auth::user()->address) }}">
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <label for="gender">Gender:</label>
                                             <select name="gender" id="gender" class=" form-control">
                                                <option value="male" @if (Auth::user()->gender == 'male') selected  @endif>Male</option>
                                                <option value="female" @if (Auth::user()->gender == 'female') selected @endif>Female</option>
                                             </select>
                                        <label for="createdAt">Latest Updated at:</label>
                                        <input type="text" name="createdAt" id="createdAt" class="form-control"
                                            value="{{ old('createdAt', Auth::user()->created_at->format('j-F-Y')) }}">

                                        <label for="role">Role</label>
                                        <input type="text" name="role" id="role" class="form-control"
                                            value="{{ Auth::user()->role }}" readonly>
                                        <button class=" btn btn-dark float-end mt-3"><i
                                                class="fa-regular fa-circle-right me-2"></i>Save</button>
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
