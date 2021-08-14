@extends('admin.layouts.app')

@section('content')
<!-- Basic datatable -->
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">{{ __('Posts') }}</h5>
				 <div class="btn-group pull-right" style="margin-right: 10px">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-dark">
                        <i class="fa fa-save"></i>&nbsp;&nbsp;New Post
                    </a>
                </div>
			</div>

			<table class="table datatable-posts">
				<thead>
					<tr>
                        <th>{{ __('Image') }}</th>
						<th>{{ __('Title') }}</th>
                        <th>{{ __('Slug') }}</th>
						<th>{{ __('Author') }}</th>
						<th>{{ __('Categories') }}</th>
						<th>{{ __('Tags') }}</th>
                        <th>{{ __('Status') }}</th>
						<th>{{ __('Created At') }}</th>
						<th class="text-center">{{ __('Action') }}</th>
					</tr>
				</thead>
				<tbody>
			  	</tbody>
			</table>
		</div>
		<!-- /basic datatable -->
@endsection
@section('js')
<script>
	var dataTable;

	jQuery(document).ready(function($){
		
		$.extend( $.fn.dataTable.defaults, {
		    language: {
		        search: '<span>Search:</span> _INPUT_',
		        searchPlaceholder: 'Type to search...'
		    },
		  });
		dataTable = $('.datatable-posts').DataTable({
			"order": [4, "desc"],
			"processing": true,
        	"serverSide": true,
        	"ajax": {
	            "url": "{{route('admin.posts.index')}}",
	            "type": "get",
	            "data": function ( data ) {
		        }
	        },
	        "columns": [
	            {data: "image","orderable": false, "searchable": false,render:function(image){
					if($.trim(image).length>0){
						return '<img src="'+image+'" class="rounded-circle" width="50" height="50">';
					}
					return "";
				}},
              	{data: "post_title",name:"posts.post_title"},
              	{data: "post_slug",name:"posts.post_slug"},
				{data: "name",name:"admins.name"},
				{data: "categories","orderable": false, "searchable": false},
				{data: "tags","orderable": false, "searchable": false},
              	{data: "post_status","name":"posts.post_status", "orderable": false, "searchable": false,render:function(status){
					if(status==1){
						return '<span class="badge badge-success">Published</span>';
					}else{
						return '<span class="badge badge-danger">Unpublished</span>';
					}
	            }},
              	{data: "created_at",name:"posts.created_at"},
	        	{data: "action", "orderable": false, "searchable": false}
	        ],

		});
		// DOM positioning
		$(document).on("click",".delete-record",function(){
			$(this).next(".delete-form").submit();
		});

		
		$(document).on("submit",".delete-form",function(){
			var form = $(this);
			var url = form.attr('action');
			var data = form.serialize();

			$.post(url,data).done(function(res){
				if(res.status==1){
					dataTable.ajax.reload();
					toastr.success(res.message);
				}
			});
			return false;
		});
		$(document).on("change",".custom-filter",function(){
				dataTable.ajax.reload();
		});

	});

</script>
@endsection