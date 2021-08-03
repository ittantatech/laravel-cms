@extends('admin.layouts.app')
@section('css')
@endsection
@section('content')
<div class="card">
  <div class="card-header header-elements-md-inline">
    <h5 class="card-title">Category</h5>
    <div class="header-elements">
      <a data-url="{{route('admin.categories.create','category')}}" href="javascript:void(0);" class="btn btn-sm btn-dark btn-labeled load_popup">Add New</a>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table datatable-category table-hover">
        <thead>
          <tr>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Parent') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Created At') }}</th>
            <th class="text-center">{{ __('Action') }}</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
@endsection
@section('js')
<div id="modal_custom" class="modal fade custom_modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content"></div>
	</div>
</div>
<script type="text/javascript">
const token = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': token
    }
});
var datatableCategory;
jQuery(document).ready(function($){
    $.extend( $.fn.dataTable.defaults, {
        language: {
            search: '<span>Search:</span> _INPUT_',
            searchPlaceholder: 'Type to search...'
        }
        });

    datatableCategory = $('.datatable-category').DataTable({
        "order": [3, "desc"],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{route('admin.categories.index','category')}}",
            "type": "get",
            "data": function ( data ) {
            }
        },
        "columns": [
            {data: "name",name:"name"},
            {data: "parent",name:"parent"},
            {data: "status",name:"status", "orderable": true, "searchable": false,render:function(status){
                if(status==1){
                    return '<span class="badge badge-success">Published</span>';
                }else{
                    return '<span class="badge badge-danger">Unpublished</span>';
                }
            }},
            {data: "created_at",name:"created_at"},
            {data: "action", "orderable": false, "searchable": false}
        ]
    });
    $('.custom_modal').on('hidden.bs.modal', function () {
        datatableCategory.ajax.reload();
    });
    $(document).on("click",".load_popup",function(){
      var url = $(this).data('url');
      var type = $(this).data('type');
      $.get(url).done(function(res){
          $(".custom_modal .modal-content").html(res);
          $(".custom_modal").modal('show');
          
          _componentSelect2();
          
      });
    });
    var _componentSelect2 = function() {
        if (!$().select2) {
            console.warn('Warning - select2.min.js is not loaded.');
            return;
        }

        // Initialize
        var $select = $('.form-control-select2').select2({
            minimumResultsForSearch: Infinity,
            width: '100%'
        });

        // Trigger value change when selection is made
        $select.on('change', function() {
            $(this).trigger('blur');
        });
    };
    $(document).on("click",".delete-record",function(){
        $(this).next(".delete-form").submit();
    });
    $(document).on("submit",".delete-form",function(){
      var refreshType = $(this).data('refresh');
      var form = $(this);
      var url = form.attr('action');
      var data = form.serialize();

      $.post(url,data).done(function(res){
        if(res.status==1){
          toastr.success(res.message);
          datatableCategory.ajax.reload()
        }
      });
      return false;
    });

    $(document).on("submit",".form-validation",function(e){
      e.preventDefault();
      var form = $(this);
      if (form.valid()) {
        var refreshType = $(this).data('refresh');

        var url = form.attr('action');
        var data = form.serialize();

        $.post(url,data).done(function(res){
          if(res.status==1){
            toastr.success(res.message);
            //refreshDataTable(refreshType);
            $(".custom_modal").modal('hide');
            form.find('.form-control').val('');
          }
        });
      }
      return false;
    });

});
</script>
@endsection