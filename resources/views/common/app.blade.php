<!DOCTYPE html>
<html lang="en">
<head>
    @include('common.meta')
    @include('common.topcss')
    <link href="" rel="icon">
    <link href="" rel="apple-touch-icon">
</head>
<body>
    @include('common.navbar')
    @yield('content')
    @include('common.footer')
</body>
    @include('common.bottomscript')
    @yield('customscript')
</html>