@section('content')
    {{Form::open(array('url' => 'users/permissions/save'))}}
    <table class="table table-bordered table-striped table-responsive table-hover">
        <thead>
            <tr>
                <th>Permission name</th>
                @foreach ($groups as $group)
                <th>{{$group->name}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
        @foreach ($permissions as $perm)
            <tr>
                <td>{{$perm->permission_name}}</td>
                <?php foreach ($groups as $group) : ?>
                <td><input type="checkbox" 
                    name="{{$perm->permission_machine_name}}|{{$group->id}}" 
                    <?php foreach ($groupPermissions as $gp): ?><?php if ($gp->permission_id == $perm->permission_id && $gp->group_id == $group->id): ?>value="{{$perm->permission_id}}|{{$group->id}}|{{$gp->allow}}"><?php endif; ?>
                    <?php endforeach; ?>
                </td>
                <?php endforeach; ?>
            </tr>
        @endforeach
        </tbody>
    </table>
    <input type="submit" value="save" name="save" class="btn btn-primary">
    {{Form::close()}}
@show