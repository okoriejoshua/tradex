<x-guest-layout>
    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Create account for free</p>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="pw" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" id="psw" class="radius-4 form-control" placeholder="Re-type password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password_confirmation')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="codeused" value="{{$refCode??''}}" class="form-control" placeholder="Referral Code (Optional)">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-users"></span>
                        </div>
                    </div>
                    @error('codeused')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="showpassword" class="toggle-password">
                            <label for="showpassword">
                                Show Password
                            </label>
                        </div>
                    </div>
                </div>
                <div class="social-auth-links text-center mb-3">
                    <x-primary-button>
                        {{ __('Create Account') }}
                    </x-primary-button>
                </div>
            </form>
            <p class="mb-0 text-center">
                Already A Member? <x-nav-link href="{{ route('login') }}">
                    {{ __('Sign In') }}
                </x-nav-link>
            </p>
        </div>
</x-guest-layout>