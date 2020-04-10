<form action="form.php" method="post">
    <p>Ваше имя: <input type="text" name="name" /></p>
    <p>Ваш возраст: <input type="text" name="age" /></p>
    <p><input type="submit" /></p>
</form>

<?php
print_r($_POST);
//echo htmlspecialchars($_POST['name']); ?><!--.-->
<!--Вам --><?php //echo (int)$_POST['age']; ?><!-- лет.-->