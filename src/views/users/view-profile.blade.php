@section('content')
<div class="row">
    <div class="col-md-12"><h1>My profile</h1></div>
</div>
@include('administer::masters.internal-nav')

<div class="row">
    <div class="col-md-4">
        <h1>{{Auth::user()->name}}</h1>
        <ul class="list-group">
          <li class="list-group-item"><strong>Email:</strong> {{Auth::user()->email}}</li>
          <li class="list-group-item"><strong>Timezone:</strong> {{Auth::user()->timezone}}</li>
        </ul>
    </div>
</div>
@show