@extends('layouts.guest.app')

@section('contents')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.request') }}" aria-label="{{ __('Reset Password') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
    <div class="wrapper" style="background:#444a69;">
      <div class="block-center mt-xl wd-xl">
         <!-- START panel-->
         <div class="panel panel-dark panel-flat" style="border:none;">
         <div class="panel-heading text-center" style="background: #282d47;     color: white;
    font-size: large;
    font-weight: 800;">
            {{ config('app.name', 'Laravel') }}
            </div>
            <div class="panel-body">
               <p class="text-center pv">PASSWORD RESET</p>
               <form role="form" method="POST" action="{{ route('password.request') }}">
               {{ csrf_field() }}
                  <!-- <p class="text-center">Fill with your mail to receive instructions on how to reset your password.</p> -->
                  @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                     @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">
                  <div class="form-group has-feedback">
                     <label for="email" class="text-muted">Email address</label>
                     <input id="email" type="email" placeholder="Enter email" autocomplete="off" class="form-control" name="email" value="{{ old('email') }}" required>
                     <span class="fa fa-envelope form-control-feedback text-muted"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label for="password" class="text-muted">Password</label>
                     <input id="password" type="password" placeholder="Password" autocomplete="off" class="form-control" name="password" required>
                     <span class="fa fa-lock form-control-feedback text-muted"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label for="password-confirm" class="text-muted">Confirm Password</label>
                     <input id="password-confirm" type="password" placeholder="Confirm Password" autocomplete="off" class="form-control" name="password_confirmation" required>
                     <span class="fa fa-lock form-control-feedback text-muted"></span>
                  </div>
                  <button type="submit" class="btn btn-danger btn-block">Send Password Reset Link</button>
               </form>
            </div>
         </div>
         <!-- END panel-->
         <div class="p-lg text-center" style="color:white;">
            
         <span>&copy; {{date('Y')}} - {{config('app.footercompanyname' )}}</span>
            <br>
            <!-- <span>Bootstrap Admin Template</span> -->
         </div>
      </div>
   </div>
@endsection
