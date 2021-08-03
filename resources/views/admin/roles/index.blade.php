@extends('admin.layouts.app')

@section('content')
        <div class="card">
                  <div class="card-header header-elements-inline">
                       <h5 class="card-title">All Roles</h5>

                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="{{ route('admin.role.create') }}" class="btn btn-sm btn-dark">
                                <i class="fa fa-save"></i>&nbsp;&nbsp;New Role
                            </a>
                        </div>
                    </div>
                    <table class="table datatable-dom-position">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Label</th>
                                    <th>Permissions</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($roles)>0)
                                  @foreach($roles as $role)
                                  <tr>
                                      <td>{{ $role->name }}</td>
                                      <td>{{ $role->label }}</td>
                                      <td><span class="badge badge-dark badge-striped">{!! $role->permissions->pluck('name')->implode('</span> <span class="badge badge-dark badge-striped">') !!}</span></td>
                                      <td>{{$role->getCreatedBy()}}</td>
                                      <td>
                                        @if(Auth::user()->hasRole('super_admin') || Auth::user()->id==$role->created_by)
                                          <a href="{{ route('admin.role.edit',$role->id) }}" class="dropdown-item" title="{{ __('Edit') }}"><i class="icon-pencil7"></i> {{ __('Edit') }}</a>
                                          @if(!Auth::user()->hasRole($role->name))
                                            <a href="javascript:void(0);" class="dropdown-item delete-record" title="{{ __('Delete') }}"><i class="icon-trash"></i> {{ __('Delete') }}</a>
                                            <form method="post" action="{{route('admin.role.destroy',$role->id)}}" class="delete-form" onsubmit="return confirm('Are you sure delete this role with his data?');">
                                                    <input type="hidden" name="_method" value="delete" />
                                              @csrf
                                            </form>
                                          @endif
                                        @endif
                                      </td>
                                  </tr>
                                  @endforeach
                                @else
                                  <tr>
                                      <td colspan="5" align="center">No Data found</td>
                                  </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Label</th>
                                    <th>Permissions</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                  
                </div>
          
     
@endsection

@section('js')
@endsection
