@section('content')
<div class="row">
    <div class="col-md-6 col-md-push-3">
        <br/>
        <br/>
        <div class="jumbotron">
            <h1>Login</h1>
            {{Form::open(array('url' => 'user/login'))}}
                <div class="form-group">
                    <input type="text" name="username" placeholder="Enter username" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter password" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="login" value="Login" class="btn btn-primary"/>
                </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@show