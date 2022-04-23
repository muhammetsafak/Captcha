<?php
session_start();
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Basic Captcha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background: #f9f9f9;
        }
        main
        {
            margin-left: auto;
            margin-right: auto;
        }
        .row {
            width: 100%;
        }

        .captcha {
            width: 270px;
            clear: both;
            margin: 10px auto 10px auto;
        }
        .captcha .captcha-img
        {
            float: left;
            height: 70px;
            clear: both;
        }
        .captcha .captcha-img img
        {
            float: left;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            border-top: 2px solid #f5f5f5;
            border-left: 2px solid #f5f5f5;
            border-bottom: 2px solid #f5f5f5;
            width: 200px;
            height: 70px;
        }
        .captcha a.captcha-refresh
        {
            border-color: #6c757d;
            color: #ffffff;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            border-top: 2px solid #f5f5f5;
            border-right: 2px solid #f5f5f5;
            border-bottom: 2px solid #f5f5f5;
            float: left;
            background: #0b5ed7;
            font-size: 16px;
            padding: 25px;
            height: 20px;
        }
        .captcha input.captcha-input
        {
            width: 250px;
            padding: 5px 5px 5px 10px;
            border-radius: 3px;
            font-size: 16px;
            margin-top: 10px;
            border: 1px solid #6c757d;
        }
    </style>
</head>
<body>
<?php
require_once dirname(__DIR__) . '/src/Captcha.php';
$captcha = new \MuhammetSafak\Captcha\Captcha();
if(isset($_POST['your_name'])){
    if($captcha->verify($_POST['captcha'])){
        // Success
        echo '<script>alert(\'Ok! Success\');</script>';
    }else{
        // Error
        echo '<script>alert(\'Error\');</script>';
    }
}
?>
<main>
    <form method="POST">

        <div class="row captcha">
            <div class="captcha-img">
                <img src="../src/image-captcha.php" id="captcha"/>
                <a onclick="captcha_refresh()" class="captcha-refresh"><i class="bi bi-arrow-clockwise"></i></a>
            </div>
            <input type="text" class="captcha-input" name="captcha" placeholder="Captcha" />
        </div>

        <input type="submit" value="Send" />
    </form>
</main>

<script>
    function captcha_refresh()
    {
        img = document.getElementById("captcha");
        img.src = '../src/image-captcha.php';
    }
</script>
</body>
</html>