<!DOCTYPE html>
<html lang="en">

<head>

    <title>@yield('title','') | Eternity - Register</title>

    @include('include.head')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        #beforeLoginContent {
            min-height: 100vh;
        }
    </style>

</head>

<body class="alt-menu sidebar-noneoverflow">
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN CONTENT PART  -->
        <div id="beforeLoginContent">
            @yield('content')
            @include('include.before-login.footer')
        </div>
    </div>
</body>

</html>