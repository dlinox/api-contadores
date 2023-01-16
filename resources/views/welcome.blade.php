<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CCPPUNO</title>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            position: relative;
            width: 100vw;
            display: flex;
            overflow: hidden;
        }

        .app {
  
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #0D3880;
        }
        .img-logo{
            width: 15rem;
            max-width: 95%;
        }
    </style>

</head>

<body class="app">

<img class="img-logo" src="/assets/imgs/logo.png" alt="">
  
</body>

</html>