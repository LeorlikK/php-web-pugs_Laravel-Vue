<?php
//// Создаем сокет
//$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//
//// Подключаемся к серверу
//socket_connect($socket, '127.0.0.1', 8080);
//
//// Отправляем данные серверу
//$message = "Привет, серверhhhhh!";
//socket_write($socket, $message, strlen($message));
//
//// Получаем ответ от сервера
//$response = socket_read($socket, 1024);
//
//// Выводим ответ
//echo "Ответ от сервера: " . $response;
//
//// Закрываем соединение
//socket_close($socket);
//?>

<?php
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_connect($socket, '127.0.0.1', 8080);

$i = 0;
while ($i < 1000) {
    $response = socket_read($socket, 1024);
    echo "Сервер говорит: " . $response . PHP_EOL;

    sleep(10);
    $i++;
}

socket_close($socket);
?>