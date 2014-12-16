@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Add Permission</h1>
    </div>
</div>
@include('administer::masters.internal-nav')
<div class="row">
    <div class="col-md-4">
        {{Form::open(array('url' => 'users/permissions/add-new'))}}
        <div class="input-group">
          <span class="input-group-addon">Name:</span>
          <input type="text" class="form-control" name="permision" placeholder="Enter the permission name">
        </div>
        <br>
        <input type="submit" name="submit" value="Save" class="btn btn-primary">
        {{Form::close()}}
    </div>
    <div class="col-md-4">
        <ul class="list-group">
        @foreach($permissions as $permission)
            <li class="list-group-item">{{$permission->permission_name}}</li>
        @endforeach
        </ul>
    </div>
</div>
@show