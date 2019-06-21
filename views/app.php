<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?= csrf_token() ?>">

        <title><?= config('app.name', 'Laravel') ?></title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet" />
    </head>
    <body>
        <div id="app"></div>
        <script charset="utf8" src="/js/bundle.js"></script>
    </body>
</html>
