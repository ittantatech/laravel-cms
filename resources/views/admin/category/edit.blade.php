<div class="modal-header">
  <h5 class="modal-title">Category</h5>
  <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
@if(!empty($category))
<form action="{{route('admin.categories.update',['category',$category->id])}}" method="post" class="form-validation" data-refresh="category">
  @csrf
  @method('PATCH')
  <div class="modal-body">
    <div class="form-group">
        <label>{{ __('Name') }}: <span class="text-danger">*</span></label>
        <input class="form-control" type="text" name="name" value="{{$category->name}}" required>
    </div>  
    <div class="form-group">
      <label>{{ __('Parent Category') }}:</label>
      <select name="categor" class="form-control" data-placeholder="Select Category">
        <option value="0">Select parent</option>
        @if(!empty($categories))
          @foreach($categories as $cat)
              <option value="{{$cat->id}}" @if($category->parent_id == $cat->id) selected="selected" @endif>{{$cat->name}}</option>
          @endforeach
        @endif
      </select>
    </div>
    <div class="form-group">
        <label>{{ __('Status') }}: <span class="text-danger">*</span></label>
        <select name="status" class="form-control required" data-placeholder="Select Status">
            <option value="1" @if($category->status == 1) selected="selected" @endif>Published</option>
            <option value="2" @if($category->status == 2) selected="selected" @endif>Unpublished</option>
        </select>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
    <button type="submit" class="btn bg-primary">Save</button>
  </div>
</form>
@else
    <div class="text-center">Record not found</div>
@endif
