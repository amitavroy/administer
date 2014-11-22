<!DOCTYPE html>
<html lang="en">
<!-- Head start-->
@include('administer::masters.head')
<!-- Head end-->

<body>
    <div class="container">
        @if(Session::get('messages'))
        <div class="message">{{AdminHelper::getMessages()}}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>