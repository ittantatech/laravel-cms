<div class="modal-header">
  <h5 class="modal-title">Tag</h5>
  <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<form action="{{route('admin.categories.store','tag')}}" method="post" class="form-validation" data-refresh="category">
  @csrf
  <div class="modal-body">
    <div class="form-group">
        <label>{{ __('Name') }}: <span class="text-danger">*</span></label>
        <input class="form-control input-tag" type="text" name="name" required>
    </div>  
    <div class="form-group">
        <label>{{ __('Status') }}: <span class="text-danger">*</span></label>
        <select name="status" class="form-control form-control-select2 required" data-placeholder="Select Status">
            <option value="1">Published</option>
            <option value="2">Unpublished</option>
        </select>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
    <button type="submit" class="btn bg-primary">Save</button>
  </div>
</form>
