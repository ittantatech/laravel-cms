@extends('admin.layouts.app')

@section('content')

<!-- Vertical form options -->
<div class="row">
	<div class="col-md-6">

		<!-- Basic layout-->
      	<form method="POST" action="{{ route('admin.admins.store') }}">
        @csrf
			<div class="card">
				<div class="card-header header-elements-inline">
                	<h5 class="card-title">{{ __('Add Admin') }}</h5>
                </div>
				<div class="card-body">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label>{{ __('Name:')}}</label>
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{old('name')}}">
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label>{{ __('Email:')}}</label>
            <input type="email" class="form-control" placeholder="Email" name="email" value="{{old('email')}}">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label>{{ __('Password:')}}</label>
            <input type="password" class="form-control" placeholder="Password" name="password" value="">
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label>{{ __('Confirm Password:')}}</label>
            <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" value="">
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
            <label>{{ __('Role:')}}</label>
            <select name="role" class="form-control">
              @if(!empty($roles))
                @foreach($roles as $role)
                  <option value="{{$role->id}}">{{$role->label}}</option>
                @endforeach
              @endif
            </select>
            @if ($errors->has('role'))
                <span class="help-block">
                    <strong>{{ $errors->first('role') }}</strong>
                </span>
            @endif
          </div>          
					<div class="text-right">
						<button type="submit" class="btn btn-dark">{{ __('Submit') }} <i class="icon-arrow-right14 position-right"></i></button>
					</div>
				</div>
			</div>
		</form>
		<!-- /basic layout -->
	</div>
</div>
<!-- /vertical form options -->

@endsection
@section('js')
<script type="text/javascript">
  jQuery(document).ready(function($){
    
  });
</script>
@endsection