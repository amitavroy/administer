@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Manage Permissions</h1>
        </div>
    </div>
    @include('administer::masters.internal-nav')
    <div class="row">
        <div class="col-md-12">
            <a href="{{url('users/permissions/add')}}" class="{{AdminHelper::activeLinkHandle('users/permissions/add')}}">+ Add permission</a>
            <br/>
            <br/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{Form::open(array('url' => 'users/permissions/save'))}}
                <table class="table table-bordered table-striped table-responsive table-hover">
                    <thead>
                        <tr>
                            <th>Permission name</th>
                            @foreach($data['groups'] as $group)
                            <th>{{$group['name']}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['permissions'] as $permission)
                        <tr>
                            <td>{{$permission['permission_name']}}</td>
                            @foreach($data['gp'] as $gp)
                                @if ($permission['permission_id'] == $gp->permission_id && $gp->allow == 0)
                                    <td>
                                    <input type="checkbox" name="{{$permission['permission_id']}}|{{$gp->group_id}}"/>
                                    <input type="hidden" name="{{$permission['permission_id']}}|{{$gp->group_id}}|hidden" value="{{$permission['permission_id']}}|{{$gp->group_id}}|{{$gp->allow}}" />
                                    </td>
                                @elseif($permission['permission_id'] == $gp->permission_id && $gp->allow == 1)
                                    <td>
                                    <input type="checkbox" name="{{$permission['permission_id']}}|{{$gp->group_id}}" checked/>
                                    <input type="hidden" name="{{$permission['permission_id']}}|{{$gp->group_id}}|hidden" value="{{$permission['permission_id']}}|{{$gp->group_id}}|{{$gp->allow}}" />
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <input type="submit" value="Save" name="save" class="btn btn-primary">
            {{Form::close()}}
        </div>
    </div>
@show