<?php
    require_once ($_SERVER["DOCUMENT_ROOT"] . "/classes/dal/DAL.php");
    if (!empty($_POST)) {
        if (!empty($_POST["userName"]) and !empty($_POST["userEmail"]) and !empty($_POST["userPassword"])) {
            (string)$username = empty($_POST["userName"]) ? "" : $_POST["userName"];
            (string)$email = empty($_POST["userEmail"]) ? "" : $_POST["userEmail"];
            (string)$password = empty($_POST["userPassword"]) ? "" : $_POST["userPassword"];

            $dal = new DAL();
            $result = $dal->CreateAccount($username, $email, $password);
            if (empty($result)) return "";

            if ($result->ErrorId == 2000) {
                $ErrorMsg = $result->Message;
            } else {
                header("Location: login.php");
                die();
            }
        } else {
            $ErrorMsg = "You forgot to fill something ?";
        }
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
<div class="main-wrapper">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">
            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-4 pe-md-0">
                                <div class="auth-side-wrapper">

                                </div>
                            </div>
                            <div class="col-md-8 ps-md-0">
                                <div class="auth-form-wrapper px-4 py-5">
                                    <?php if (!empty($ErrorMsg)): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <i data-feather="alert-circle"></i>
                                            <?php echo $ErrorMsg; ?>
                                        </div>
                                    <?php endif; ?>
                                    <a class="noble-ui-logo d-block mb-2">PHP Simple Login / Registration</a>
                                    <h5 class="text-muted fw-normal mb-4">Create a free account.</h5>
                                    <form class="forms-sample" method="post">
                                        <div class="mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="userName" placeholder="Name">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" name="userEmail" placeholder="Email">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="userPassword" placeholder="Password" autocomplete="current-password">
                                        </div>

                                        <div>
                                            <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0 text-white">Sign up</button>
                                        </div>
                                        <a href="login.php" class="d-block mt-3 text-muted">Already a user? Sign in</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/vendors/core/core.js"></script>
<script src="assets/vendors/feather-icons/feather.min.js"></script>
<script src="assets/js/template.js"></script>
</body>
</html>