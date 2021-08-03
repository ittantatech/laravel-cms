@extends('admin.layouts.app')

@section('content')
<!-- Page content -->
	<div class="page-content pt-0">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content">
				<div class="d-flex align-items-start flex-column flex-md-row">
					<div class="card w-100">
						<div class="card-header header-elements-inline">
							<h5 class="card-title">Profile information</h5>
						</div>

						<div class="card-body">
							<form action="{{route('admin.profile.update')}}" method="post">
								@csrf
								@method('patch')
								<div class="form-group">
		                            <label for="name" class="col-form-label">{{ __('Name') }}</label>

		                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name',$user->name) }}" required autofocus>

		                                @if ($errors->has('name'))
		                                    <span class="invalid-feedback" role="alert">
		                                        <strong>{{ $errors->first('name') }}</strong>
		                                    </span>
		                                @endif
		                            
		                        </div>

								<div class="form-group">
		                            <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>
		                                <div class="form-group form-group-feedback form-group-feedback-left">
		                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email',$user->email) }}" required>
		                                <div class="form-control-feedback">
		                                    <i class="icon-mention text-muted"></i>
		                                </div>
		                                @if ($errors->has('email'))
		                                    <span class="invalid-feedback" role="alert">
		                                        <strong>{{ $errors->first('email') }}</strong>
		                                    </span>
		                                @endif
		                                </div>
		                            
		                        </div>
		                        
								<div class="form-group">
		                            <label for="password" class="col-form-label">{{ __('New Password') }}</label>
		                                <div class="form-group form-group-feedback form-group-feedback-left">
		                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
		                                <div class="form-control-feedback">
		                                    <i class="icon-user-lock text-muted"></i>
		                                </div>
		                                @if ($errors->has('password'))
		                                    <span class="invalid-feedback" role="alert">
		                                        <strong>{{ $errors->first('password') }}</strong>
		                                    </span>
		                                @endif
		                                </div>
		                            
		                        </div>

		                        <div class="form-group">
		                            <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>
		                                <div class="form-group form-group-feedback form-group-feedback-left">
		                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
		                                <div class="form-control-feedback">
		                                    <i class="icon-user-lock text-muted"></i>
		                                </div>
		                                </div>
		                            
		                        </div>
								
		                        <div class="text-right">
		                        	<button type="submit" class="btn btn-dark">Save changes</button>
		                        </div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /content area -->
		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->
@endsection

@section('js')
<script type="text/javascript">
	$('.form-input-styled').uniform({
        fileButtonClass: 'action btn bg-warning'
    });
</script>
@endsection