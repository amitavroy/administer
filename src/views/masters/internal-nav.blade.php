<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills">
          <li role="presentation" class="{{AdminHelper::activeLinkHandle('users/dashboard')}}"><a href="{{url('users/dashboard')}}">Dashboard</a></li>
          <li role="presentation" class="{{AdminHelper::activeLinkHandle('users/permissions/manage')}}"><a href="{{url('users/permissions/manage')}}">Manage Permission</a></li>
          <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                  Profile <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li class="{{AdminHelper::activeLinkHandle('users/profile/view')}}"><a href="{{url('users/profile/view')}}">View profile</a></li>
                  <li class="{{AdminHelper::activeLinkHandle('users/profile/edit')}}"><a href="{{url('users/profile/edit')}}">Edit profile</a></li>
                </ul>
            </li>
          <li role="presentation" class="{{AdminHelper::activeLinkHandle('users/logout')}}"><a href="{{url('users/logout')}}">Logout</a></li>
        </ul>
    </div>
</div>
<br/>