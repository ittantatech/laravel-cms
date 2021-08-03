@extends('admin.layouts.app')

@section('content')
<!-- Basic datatable -->
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">{{ __('Admins') }}</h5>
				 <div class="btn-group pull-right" style="margin-right: 10px">
                    <a href="{{ route('admin.admins.create') }}" class="btn btn-sm btn-dark">
                        <i class="fa fa-save"></i>&nbsp;&nbsp;New Admin
                    </a>
                </div>
			</div>

			<table class="table datatable-dom-position">
				<thead>
					<tr>
						<th>{{ __('Name') }}</th>
						<th>{{ __('Email') }}</th>
						<th>{{ __('Created By') }}</th>
						<th>{{ __('Role') }}</th>
						<th class="text-center">{{ __('Action') }}</th>
					</tr>
				</thead>
				<tbody>
			    	@if(!empty($admins))
			    		@foreach($admins as $admin)
			    			<tr>
			    				<td>{{$admin->name}}</td>
			    				<td>{{$admin->email}}</td>
			    				<td>{{$admin->getCreatedByName()}}</td>
			    				<td>{{$admin->roles[0]->label}}</td>
			    				<td class="text-center">
			    					<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="{{ route('admin.admins.edit',$admin->id) }}" class="dropdown-item" title="{{ __('Edit') }}"><i class="icon-pencil7"></i> {{ __('Edit') }}</a>
												<a href="javascript:void(0);" class="dropdown-item delete-record" title="{{ __('Delete') }}"><i class="icon-trash"></i> {{ __('Delete') }}</a>
												<form method="post" action="{{route('admin.admins.destroy',$admin->id)}}" class="delete-form" onsubmit="return confirm('Are you sure delete this admin with his data?');">
				            						<input type="hidden" name="_method" value="delete" />
													@csrf
				            					</form>
											</div>
										</div>
									</div>
			    				</td>
			    			</tr>
			    		@endforeach
			    	@endif
				</tbody>
			</table>
		</div>
		<!-- /basic datatable -->
@endsection
@section('js')
<script>
jQuery(document).ready(function($){
	
	$(document).on("click",".delete-record",function(){
		$(this).next(".delete-form").submit();
	});

});
</script>
@endsection