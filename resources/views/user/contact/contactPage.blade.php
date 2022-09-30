@extends('user.layouts.master')
@section('content')
    <div class="row">
        <div class="col-6 offset-3">
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="">
                            {{-- alert --}}
                            @if (session('Success'))
                                <div class="col-8 offset-2">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong><i class="fa-solid fa-check"></i>{{ session('Success') }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                            {{-- end alert --}}

                            <div class="card shadow-lg ">
                                <div class="card-body">
                                    <div class="card-title mb-5" style=" border-bottom: 1px solid black;">
                                        <h3 class="text-center title-2">Get In Touch With Admins</h3>
                                    </div>
                                    <form action="{{ route('user@contactData') }}" method="post" novalidate="novalidate">
                                        @csrf
                                        <input type="hidden" name="userId" value=" {{ Auth::user()->id }}">
                                        <div class="form-group">
                                            <label for="email">Email::</label>
                                            <input type="email" name="email" id="email"
                                                class=" form-control shadow-sm @error('email')
                                                is-invalid
                                                @enderror" value=" {{ old('email') }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Your Message</label>
                                            <textarea name="message" id="message" cols="30" rows="10" placeholder="Your Message Goes Here..."
                                                class=" form-control shadow-sm @error('message')
                                      is-invalid
                                      @enderror">{{ old('message') }}</textarea>
                                            @error('message')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-outline-secondary shadow-sm"><i
                                                    class="fa-regular fa-paper-plane mr-2"></i>Send</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
