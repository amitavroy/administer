<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills">
          <li role="presentation" class="{{AdminHelper::activeLinkHandle('user/dashboard')}}"><a href="{{url('user/dashboard')}}">Dashboard</a></li>
          <li role="presentation" class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                Profile <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li class="{{AdminHelper::activeLinkHandle('user/profile/view')}}"><a href="{{url('user/profile/view')}}">View profile</a></li>
                <li class="{{AdminHelper::activeLinkHandle('user/profile/edit')}}"><a href="{{url('user/profile/edit')}}">Edit profile</a></li>
              </ul>
          </li>
          <li role="presentation" class="{{AdminHelper::activeLinkHandle('user/logout')}}"><a href="{{url('user/logout')}}">Logout</a></li>
        </ul>
    </div>
</div>