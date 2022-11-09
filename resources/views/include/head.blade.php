<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

<link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon.ico')}}"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <link href="{{asset('assets/css/loader.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('assets/js/loader.js')}}"></script> -->

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
<link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<link href="{{asset('plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/css/dashboard/dash_2.css')}}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/widgets/modules-widgets.css')}}">
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

<link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-step/jquery.steps.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<style>
    *::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }

    *::-webkit-scrollbar-thumb {
        border-radius: 50vh;
        background-color: #00a85980;
    }
    *::-webkit-scrollbar-thumb:hover {
        background-color: #00a859;
    }
    *::selection {
        color: #00a859;
        background: #00a85921;
    }
</style>
<style class="dark-theme">
    #chart-2 path {
        stroke: #0e1726;
    }

    .navbar {
        z-index: 1030;
        padding: 4px 0 4px 0;
        background: transparent;
        margin: 0 11px;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11/dist/vue.min.js"
        integrity="sha256-ngFW3UnAN0Tnm76mDuu7uUtYEcG3G5H1+zioJw3t+68=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"
        integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>
