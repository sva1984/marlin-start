<?php

//namespace app\store;

class PdoRepository
{
    private $pdo;

   public function __construct()
   {
       $driver = 'mysql'; // тип базы данных, с которой мы будем работать
       $host = 'localhost';// альтернатива '127.0.0.1' - адрес хоста, в нашем случае локального
       $db_name = 'start'; // имя базы данных
       $db_user = 'root'; // имя пользователя для базы данных
       $db_password = ''; // пароль пользователя
       $charset = 'utf8'; // кодировка по умолчанию
       $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
       // массив с дополнительными настройками подключения. В данном примере мы установили отображение ошибок, связанных с базой данных, в виде исключений
       $dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";
       $this->pdo = new PDO($dsn, $db_user, $db_password, $options);
   }

   public function getPdo()
   {
        return $this->pdo;
    }

    public function test()
    {
        return "test";
    }
}
