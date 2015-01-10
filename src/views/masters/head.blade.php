<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
@if (isset($pageTitle))
    <title>{{ $pageTitle }}</title>
@else
    <title>{{ AdminHelper::getConfig('app-title') }}</title>
@endif
    <link rel="stylesheet" href="{{asset('packages/amitavroy/administer/bootstrap-ubuntu.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('packages/amitavroy/administer/animate.css')}}"/>

    @section('scripts')
<script type="text/javascript" src="{{asset('packages/amitavroy/administer/jquery-1.11.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('packages/amitavroy/administer/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('packages/amitavroy/administer/administer-scripts.min.js')}}"></script>
    @show

</head>
