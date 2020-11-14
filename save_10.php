<?php
session_start();

// получили текст
$text =$_POST['text'];

//подключаемся к БД
$pdo = new PDO("mysql:host=localhost;dbname=my_project;", "root", "root");
// формируем запрос на получение столбца text
$sql = "SELECT * FROM my_table WHERE text=:text";
//подготавливаем запрос
$statement = $pdo->prepare($sql);
//выполняем запрос
$statement->execute(['text' => $text]);
//получаем одну запись (fetch)
$task = $statement->fetch(PDO::FETCH_ASSOC);
//выполняется проверка, если есть запись то выводится массив.
//var_dump($task);die();
// Если нету то false.


//создаем условие: если переменная не пустая выводим сообщение
//если пустая - переходим на вставку данных
if (!empty($task)) {
    $message = "Введенная запись уже присутствует в таблице.";
    //записываем в сессию.
    //Глобальный массив $_SESSION['подключен message'] = передаем данную перемену message
    $_SESSION['danger'] = $message;

    header("Location: ./task_10.php");
    exit;
}



//запрос на вставку данных
$sql = "INSERT INTO my_table (text) VALUES (:text)";
$statement = $pdo->prepare($sql);
$statement->execute(['text' => $text]);

$message = "Данные успешно добавлены.";
$_SESSION['success'] = $message;

//перенаправляем обратно на страницу
header("Location: ./task_10.php");
