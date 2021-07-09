@extends('master')
@section('content')
<div class="container">
		<div id="content">
			<form action="{{route('postLoginAd')}}" method="post" class="beta-form-checkout">
            @csrf
                <div class="row">
					<div class="col-sm-3"></div>
                    @if(Session::has('flag'))
                    <div class="alert alert {{Session::get('flag')}}">{{Session::get('message')}}</div>
                    @endif
					<div class="col-sm-6">
						<h4>Đăng nhập</h4>
						<div class="space20">&nbsp;</div>
						<div class="form-block">
							<label for="email">Email address*</label>
							<input type="email" name="email" id="email" required>
						</div>
						<div class="form-block">
							<label for="phone">Password*</label>
							<input type="password" name="password" id="password" required>
						</div>
						<div class="form-block">
							<button type="submit" class="btn btn-primary">Login</button>
						</div>
						<div class="form-block">
						<p>Bạn chưa có tài khoản ?<a href="{{route('postSignupAd')}}" style="color:blue"> Đăng ký ngay</a></p>
						</div>
					</div>
					<div class="col-sm-3"></div>
				</div>
			</form>
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection