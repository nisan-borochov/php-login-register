<?php
    error_reporting(E_ERROR);
    session_start();

    if (!isset($_SESSION["UserId"])) {
        header("Location: login.php");
        die();
    }
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="Simple PHP Login / Registration">
        <meta name="name" content="Nisan Borochov">
        <title>PHP - Simple Login / Registration</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
        <!-- END Fonts -->

        <!-- Layout Styles -->
        <link rel="stylesheet" href="assets/vendors/core/core.css">
        <link rel="stylesheet" href="assets/fonts/feather-font/css/iconfont.css">
        <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
        <link rel="stylesheet" href="assets/css/demo1/style.css">
        <link rel="stylesheet" href="assets/style.css">
        <!-- END Layout Styles -->
    </head>
    <body>
        <div style="display: flex; align-items: center; justify-content: center; flex-direction: column; margin-top: 25px;">
            <span>Welcome back, <span style="color: #6571ff;"><?php echo $_SESSION["FullName"]; ?></span></span>
            <span>Click here to <a href="logout.php" style="color: #6571ff;" class="mouseHover">logout</a></span>
        </div>
        <script src="assets/vendors/feather-icons/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
    </body>
</html>
