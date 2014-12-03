@section('content')
<div class="row">
    <div class="col-md-7 col-md-push-2">
        <br/>
        <br/>
        <div class="jumbotron">
            <h1>Access Denied!</h1>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        if ($('.message .alert.alert-warning').length) {
            $('.message').hide();
            $('.jumbotron').addClass('animated shake');
        }
    });
</script>
@show