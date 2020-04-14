<?php
session_start();
if(isset($_SESSION['success']) || isset($_SESSION['success_pass'])) {
    header('Refresh:3; url=http://marlin-start/profile.php');
}

function errorMessage($flagName)
{
    if(isset($_SESSION[$flagName])){
        echo "<h5 style='color:#ff0419'>$_SESSION[$flagName]</h5>";
        unset($_SESSION[$flagName]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <?php
                        if(isset($_SESSION['name'])){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link" href="profile.php">' . $_SESSION['name'] . '</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="store/LogOutService.php">Logout</a>
                            </li>';
                        } else echo '
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>';
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
          <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><h3>Профиль пользователя</h3></div>

                        <div class="card-body">
                                 <?php if(isset($_SESSION['success']))
                                    echo '<div class="alert alert-success" role="alert">
                                            Профиль успешно обновлен
                                           </div>';
                                    unset($_SESSION['success'])?>
                            <form action="store/ProfileService.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Name</label>
                                            <input type="text" class="form-control" name="name" id="exampleFormControlInput1" value="<?php echo $_SESSION['name']?>">
                                           
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Email</label>
                                            <input type="email" class="form-control" name="email" id="exampleFormControlInput1" value=<?php echo $_SESSION['email']?>>
                                            <?php errorMessage('err_email');?>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Аватар</label>
                                            <input type="file" class="form-control" name="image" id="exampleFormControlInput1">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        if(!empty($_SESSION['img_url'])){
                                            echo '<img src="img/' . $_SESSION['img_url'] . '" alt="" class="img-fluid">';
                                        }else echo '<img src="img/no-user.jpg" alt="" class="img-fluid">';
                                        ?>

                                    </div>

                                    <div class="col-md-12">
                                        <button class="btn btn-warning">Edit profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-header"><h3>Безопасность</h3></div>
                         <div class="card-body">
                        <?php if(isset($_SESSION['success_pass']))
                        echo '<div class="alert alert-success" role="alert">
                                Пароль успешно обновлен
                            </div>';
                        unset($_SESSION['success_pass']);
                            ?>


                            <form action="store/ChangePasswordService.php" method="post">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Current password</label>
                                            <input type="password" name="current" class="form-control" id="exampleFormControlInput1">
                                            <?php errorMessage('err_pass_virify');?>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">New password</label>
                                            <input type="password" name="password" class="form-control" id="exampleFormControlInput1">
                                            <?php errorMessage('err_confirm_pass');?>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Password confirmation</label>
                                            <input type="password" name="password_confirmation" class="form-control" id="exampleFormControlInput1">
                                        </div>

                                        <button class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </main>
    </div>
</body>
</html>
