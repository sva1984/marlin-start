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
                                function img($img)
                                {
                                    if(!empty($img)){
                                        return $img;
                                    }else return 'no-user.jpg';
                                }
                                function comment($user, $comment, $img, $date)
                                {
                                   echo "<div class='media'>
                                              <img src='img/" . img($img) . "' class='mr-3' alt=''...' width='64' height='64'>
                                              <div class='media-body''>
                                                <h5 class='mt-0'>$user</h5> 
                                                <span><small>$date</small></span>
                                                <p>$comment</p>
                                              </div>
                                            </div>";
                                }
                                $pdoRepository = new PdoRepository();
                                $pdo = $pdoRepository->getPdo();
                                $sql = "SELECT comment.id, comment.comment, comment.date, `user`.name, `user`.img_url
                                        FROM comment
                                        JOIN user ON comment.id_user = user.id
                                        ORDER BY comment.id DESC";
                                $statment = $pdo->prepare($sql);
                                $statment->execute();
                                $comments = $statment->fetchAll(PDO::FETCH_ASSOC);
//                                echo "<pre>";
//                                print_r($comments); die;
                                foreach ($comments as $comment){
                                    $commentDate = date('d/m/Y', $comment['date']);
                                    comment($comment['name'], $comment['comment'], $comment['img_url'], $commentDate);
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
                                    <?php
                                    if(isset($_SESSION['name']))
                                    echo '
                                     <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщение</label>
                                    <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>' .
                                      errorMessage('text', 'Введите комментарий !!!!') .
                            '</div>
                            <button type="submit" class="btn btn-success">Отправить</button>';
                                    else echo '<div class=\"card-body\">
                                              <div class=\"alert alert-success\" role=\"alert\">
                                                <h5 style=\'color:#15791E\'>Для добавления комментария необходимо авторизоваться</h5>
                                              </div>';
                                    ?>

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
