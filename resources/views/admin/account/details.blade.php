@extends('admin.layouts.master')

@section('title','Account Details')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">

        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Account Details</h3>
                        </div>
                        <hr>
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
                        {{-- end of updated success message --}}
                        <div class="row">
                        <div class=" col-3 offset-1">
                            @if (Auth::user()->image == null)
                             @if (Auth::user()->gender == "male")
                             <img src="{{ asset('image/default_user_profile.jpeg') }}" alt="John Doe" />
                             @else
                             <img src="{{ asset('image/female_default_user_profile.png') }}" alt="John Doe" />
                             @endif
                          @else
                              <img src="{{ asset('storage/'.Auth::user()->image) }}" class="shadow-sm" />
                          @endif
                        </div>
                        <div class="col-8">
                           <form action="">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control text-capitalize" value="{{ Auth::user()->name }}" readonly>

                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" readonly>

                            <label for="phone">Phone:</label>
                            <input type="number" name="phone" id="phone" class="form-control" value="{{ Auth::user()->phone }}" readonly>

                            <label for="address">Address:</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ Auth::user()->address }}" readonly>

                            <label for="gender">Gender:</label>
                            <input type="text" name="gender" id="gender" class="form-control" value="{{ Auth::user()->gender }}" readonly>

                            <label for="createdAt">Latest Updated at:</label>
                            <input type="text" name="createdAt" id="createdAt" class="form-control" value="{{ Auth::user()->created_at->format('j-F-Y') }}" readonly>
                           </form>
                        </div>
                        </div>
                        <div class="row">
                          <div class=" col-3 offset-9 mt-4">
                            <a href="{{ route('admin@editDetailsPage') }}">
                                <button class="btn btn-dark">Edit Details</button>
                            </a>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
