@extends('admin.layouts.app')
@section('content')
        <div class="row">
            <!-- left column -->
            <div class="col-md-7">
                <form method="POST" action="{{ route('admin.role.update',$role->id) }}">
                @csrf
                @method('PATCH')
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">{{ __('Add Role') }}</h5>
                        </div>
                
                    <div class="card-body">
                        
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                  <label>{{ __('Name:')}}</label>
                                  <input type="text" class="form-control" placeholder="Name" name="name" value="{{old('name',$role->name)}}">
                                  @if ($errors->has('name'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('name') }}</strong>
                                      </span>
                                  @endif
                                </div>

                                <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                                  <label>{{ __('Role Label:')}}</label>
                                  <input type="text" class="form-control" placeholder="Role Label" name="label" value="{{old('label',$role->label)}}">
                                  @if ($errors->has('label'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('label') }}</strong>
                                      </span>
                                  @endif
                                </div>

                                <div class="role-permissions form-group {{ $errors->has('permission') ? ' has-error' : '' }}">
                                    <label>{{ __('Role Permissions:')}}</label>
                                    <input type="checkbox" id="selectall" value="all"> <label style="cursor: pointer;" for="selectall">All</label>
                                    @if($errors->has('permission'))
                                    <span class="help-block">
                                        {{ $errors->first('permission') }}
                                    </span>
                                    @endif

                                    <ul class="permissions-list">
                                        @foreach($permissions as $key => $value)
                                        <li class="group-checkbox-list-li">
                                            <input type="checkbox" class="checkbox-group {{ (empty($key) ? 'dashboard' : $key) }}" value="{{ (empty($key) ? 'dashboard' : $key) }}" id="check_{{$key}}">&nbsp;&nbsp;&nbsp;<label style="cursor: pointer;" for="check_{{$key}}">{{ (empty($key) ? '*' : ucfirst($key))  }}</label>
                                            <ul class="checkbox-group-child-ul row">
                                                @foreach($value as $permission) 
                                                <li class="col-xs-12 col-md-4">
                                                    <input class="checkbox-group-child" id="check_id_{{$permission->id}}" type="checkbox" value="{{ $permission->id }}" name="permission[]" {{ (isset($role) ? (in_array($permission->id,$role->permissions->pluck('id')->toArray()) ? 'checked=checked' : '') : '')}}> &nbsp;&nbsp;&nbsp;<label style="cursor: pointer;" for="check_id_{{$permission->id}}">{{ ucfirst(str_replace('-',' ',$permission->name)) }}</label>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div> 


                                <button type="submit" class="btn btn-dark pull-right">Create</button>
                            </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
@endsection
@section('js')
<script type="text/javascript">
    class customJs {

        checkIsAllChecked(obj){
            if(obj.is(":checked")==true){
                var allcheckBox=obj.parents('.checkbox-group-child-ul').find('input[type="checkbox"]').length;
                var allcheckedBox=obj.parents('.checkbox-group-child-ul').find('input[type="checkbox"]:checked').length;
                if(allcheckBox==allcheckedBox){
                    obj.parents('.group-checkbox-list-li').find('.checkbox-group').prop('checked',true);
                }
            }else{
                obj.parents('.group-checkbox-list-li').find('.checkbox-group').prop('checked',false);
            }
            cJS.checkmainCheckbox();
        }

        selectallChange(Obj) {
            if (Obj.is(':checked')) {
                $('input[type=checkbox]').prop('checked',true);
            } else {
                $('input[type=checkbox]').prop('checked',false);
            }
        }

    checkboxGroupChange(Obj) {

        if (Obj.is(':checked')) {
            Obj.siblings('ul').find("input[type='checkbox']").prop('checked',true);
        } else {
            Obj.siblings('ul').find("input[type='checkbox']").prop('checked',false);
        }
        cJS.checkmainCheckbox();
    }

    checkmainCheckbox(){
        var allcheckBox=$('.permissions-list input[type="checkbox"]').length;
        var allcheckedBox=$('.permissions-list input[type="checkbox"]:checked').length;
        if(allcheckBox==allcheckedBox){
            $('#selectall').prop('checked',true);
        }else{
            $('#selectall').prop('checked',false);
        }
    }
}
let cJS = new customJs;

$(document).ready(function () {
   
   

    if ($('.permissions-list').length > 0) {
       $('.permissions-list input[type="checkbox"]').each(function(){
           cJS.checkIsAllChecked($(this));
       });
    }
    $(document).on('change', '#selectall', function () {
        cJS.selectallChange($(this));
    });

    $(document).on('change', '.checkbox-group', function () {
        cJS.checkboxGroupChange($(this));
    });


    $(document).on("change",'.checkbox-group-child',function(){
       cJS.checkIsAllChecked($(this));
    });

});
</script>
@endsection