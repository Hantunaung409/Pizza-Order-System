@extends('user.layouts.master')

@section('content')
   <div class="row">
    <div class="col-6 offset-3">
        <div class="main-content">
            <div class="section__content section__content--p30">

                <div class="container-fluid">
                    <div class="">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h3 class="text-center title-2">Change Password</h3>
                                </div>


                                <hr>
                                <form action="{{ route('user@changePassword') }}" method="post" novalidate="novalidate">
                                    @csrf
                                    <div class="form-group">
                                        <label for="oldPassword" class="control-label mb-1">Old Password</label>
                                        <input id="oldPassword" name="oldPassword" type="password" class="form-control @error('oldPassword')
                                        is-invalid
                                        @enderror @if (session('notMatch'))
                                            is-invalid
                                        @endif" aria-required="true" aria-invalid="false" placeholder="Old password">
                                        {{-- in the class ,,,,if only is-invlalid without the @error() ,,, the border of form gonna be red --}}
                                        @error('oldPassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if(session('notMatch'))
                                          <div class="invalid-feedback">{{ session('notMatch') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="newPassword" class="control-label mb-1">New Password</label>
                                        <input id="newPassword" name="newPassword" type="password" class="form-control @error('newPassword')
                                        is-invalid
                                        @enderror" aria-required="true" aria-invalid="false" placeholder="New Password">
                                        {{-- in the class ,,,,if only is-invlalid without the @error() ,,, the border of form gonna be red --}}
                                        @error('newPassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmPassword" class="control-label mb-1">Confirm Password</label>
                                        <input id="confirmPassword" name="confirmPassword" type="password" class="form-control @error('confirmPassword')
                                        is-invalid
                                        @enderror" aria-required="true" aria-invalid="false" placeholder="Confirm Password">
                                        {{-- in the class ,,,,if only is-invlalid without the @error() ,,, the border of form gonna be red --}}
                                        @error('confirmPassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <button id="payment-button" type="submit" class="btn btn-lg btn-dark text-white btn-block">
                                            <span id="payment-button-amount">Save</span>
                                            {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                            <i class="fa-solid fa-key"></i>
                                        </button>
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
