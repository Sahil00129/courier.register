<!DOCTYPE html>
<html lang="en">

<head>

    <title>@yield('title','') | Eternity - Register</title>

    @include('include.head')

</head>

<body class="alt-menu sidebar-noneoverflow">
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content" style="margin-top: 44px;">
            @yield('content')
            @include('include.before-login.footer')
        </div>
</body>

</html>