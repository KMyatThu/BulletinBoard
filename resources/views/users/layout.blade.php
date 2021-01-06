<!DOCTYPE html>
<html>
<head>
    <title>OJT BulletinBoard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  
<div class="container">
    @yield('content')
</div>

</body>
</html>