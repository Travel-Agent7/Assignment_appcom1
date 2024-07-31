@extends('layouts.guest')

@section('content')
    <title>Register</title>
    <div class="container">
        <div class="card card-register mx-auto mt-5">
            <div class="card-header">
                <h2>Create Account</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" id="fullname" name="fullname" class="form-control"
                                        placeholder="Full Name" required="required" autofocus="autofocus"
                                        value="{{ old('fullname') }}">
                                    <label for="fullname">Full Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="number" id="phone" name="phone" class="form-control"
                                        placeholder="Phone Number" min="0" required="required"
                                        value="{{ old('phone') }}">
                                    <label for="phone">Phone Number</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="Email address" required="required" value="{{ old('email') }}">
                            <label for="email">Email address</label>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="state">Select State</label>
                        <select class="form-control" id="state" name="state">
                            <option value="" disabled selected>Select a State</option>
                            <option value="Dubai" {{ old('state') == 'Dubai' ? 'selected' : '' }}>Dubai</option>
                            <option value="Sharjah" {{ old('state') == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
                            <option value="Abu Dhabi" {{ old('state') == 'Abu Dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
                            <option value="Ajman" {{ old('state') == 'Ajman' ? 'selected' : '' }}>Ajman</option>
                            <option value="Ras Al Khaimah" {{ old('state') == 'Ras Al Khaimah' ? 'selected' : '' }}>Ras Al
                                Khaimah</option>
                            <option value="Umm Al Quwain" {{ old('state') == 'Umm Al Quwain' ? 'selected' : '' }}>Umm Al
                                Quwain</option>
                            <option value="Fujairah" {{ old('state') == 'Fujairah' ? 'selected' : '' }}>Fujairah</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="city">Select City</label>
                        <select class="form-control" id="city" name="city">
                            <option value="">Select a city</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="password" id="inputPassword" name="password" class="form-control"
                                        placeholder="Password" required="required">
                                    <label for="inputPassword">Password</label>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="password" id="confirmPassword" name="password_confirmation"
                                        class="form-control" placeholder="Confirm password" required="required">
                                    <label for="confirmPassword">Confirm password</label>
                                    @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="file" id="image" name="profile_image" class="form-control"
                                placeholder="Profile Image" required="required">
                            <label for="image">Profile Image</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                </form>
                <div class="text-center">
                    <a class="d-block small mt-3" href="{{ route('login') }}">Already Have Account? Log In</a>
                </div>
            </div>
        </div>
    </div>
@endsection
