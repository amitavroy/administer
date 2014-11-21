@section('content')
<div class="row">
    <div class="col-md-12"><h1>Edit my profile</h1></div>
</div>
@include('administer::masters.internal-nav')
<div class="row">
    <div class="col-md-5">
    {{Form::open(array('url' => 'user/profile/update'))}}
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">Name:</div>
            <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}"/>
        </div>
        <p><span class="error-display">{{$errors->first('name')}}</span></p>
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">Email:</div>
            <input type="text" name="email" class="form-control" value="{{Auth::user()->email}}"/>
        </div>
        <p><span class="error-display">{{$errors->first('email')}}</span></p>
    </div>

    <div class="jumbotron1">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">Current password:</div>
                <input type="password" name="current_pass" class="form-control" value=""/>
            </div>
            <p class="help-block">Curreny password is required if you are changing your password.</p>
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">New password:</div>
                <input type="password" name="new_pass" class="form-control"/>
            </div>
            <p><span class="error-display">{{$errors->first('new_pass')}}</span></p>
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">Confirm password:</div>
                <input type="password" name="conf_pass" class="form-control"/>
            </div>
            <p><span class="error-display">{{$errors->first('conf_pass')}}</span></p>
        </div>

        <input type="submit" name="submit" value="Save" class="btn btn-primary"/>
    </div>
    {{Form::close()}}
    </div>
</div>
@show