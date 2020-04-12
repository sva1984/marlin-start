<?php
session_start();
if(isset($_SESSION['success'])) {
    header('Refresh:3; url=http://marlin-start/index.php');
}

function errorMessage($flagName, $text)
{
     if(isset($_SESSION[$flagName])){
          echo "<h1 style='color:#ff0419'>$text</h1>";
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
//                           print_r($_SESSION); die;
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
                            <div class="card-header"><h3>Комментарии</h3></div>

                                <?php
                                include "store/PdoRepository.php";

                                if(isset($_SESSION['success'])){
                                    echo '<div class="card-body">
                                              <div class="alert alert-success" role="alert">
                                                Комментарий успешно добавлен
                                              </div>';
                                    unset($_SESSION['success']);
                                }

                                function comment($user, $comment, $date)
                                {
                                   echo "<div class='media'>
                                              <img src='img/no-user.jpg' class='mr-3' alt=''...' width='64' height='64'>
                                              <div class='media-body''>
                                                <h5 class='mt-0'>$user</h5> 
                                                <span><small>$date</small></span>
                                                <p>$comment</p>
                                              </div>
                                            </div>";
                                }
                                $pdoRepository = new PdoRepository();
                                $pdo = $pdoRepository->getPdo();
                                $sql = "SELECT * FROM comment ORDER BY id DESC";
                                $statment = $pdo->prepare($sql);
                                $statment->execute();
                                $comments = $statment->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($comments as $comment){
                                    $commentDate = date('d/m/Y', $comment['date']);
                                    comment($comment['name'], $comment['comment'], $commentDate);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-header"><h3>Оставить комментарий</h3></div>

                            <div class="card-body">
                                <form action="store/createCommentService.php" method="post">
                                    <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Имя</label>
                                    <input name="name" class="form-control" id="exampleFormControlTextarea1" />
                                        <?php
                                        errorMessage('emptyName', 'Введите имя !!!!');
                                        ?>
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщение</label>
                                    <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                      <?php
                                      errorMessage('text', 'Введите комментарий !!!!');
                                      ?>
                                  </div>
                                  <button type="submit" class="btn btn-success">Отправить</button>
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
