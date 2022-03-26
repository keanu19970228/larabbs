{{--主要布局文件，项目的所有页面都将继承于此页面；--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{--  SCRF Token--}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title','LaraBBS')</title>
  <meta name="description" content="@yield('description', 'LaraBBS')" />

  {{--  styles --}}
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  @yield('styles')

</head>

<body>
  <div id="app" class="{{ route_class() }}-page">

    @include('layouts._header')

      <div class="container">

        @include('shared._messages')

        @yield('content')

      </div>

      @include('layouts._footer')
  </div>

  {{--  Script  --}}
  <script src="{{ mix('js/app.js') }}"></script>

  @yield('scripts')

</body>

</html>
