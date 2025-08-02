<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- 解决CSRF报错 -->
  </head>
  <body>
    <div id="app">
        d222222
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
  </body>
  </html>