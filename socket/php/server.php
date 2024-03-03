<?php
//// Создаем сокет
//$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//
//// Связываем сокет с адресом и портом
//socket_bind($socket, '127.0.0.1', 8080);
//
//// Начинаем прослушивание сокета
//socket_listen($socket);
//
//// Принимаем входящее соединение
//$client_socket = socket_accept($socket);
//
//// Отправляем данные клиенту
//socket_write($client_socket, "Привет, клиент!");
//
//// Закрываем соединения
//socket_close($client_socket);
//socket_close($socket);
//?>

<?php
//// Создаем сокет
//$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//
//// Связываем сокет с адресом и портом
//socket_bind($socket, '127.0.0.1', 8080);
//
//// Начинаем прослушивание сокета
//socket_listen($socket);
//
//echo "Сервер запущен. Прослушиваем порт 8080...\n";
//
//while (true) {
//    // Принимаем входящее соединение
//    $client_socket = socket_accept($socket);
//
//    // Читаем данные от клиента
//    $input = socket_read($client_socket, 1024);
//
//    // Отправляем данные обратно клиенту
//    socket_write($client_socket, "Вы отправили: " . $input);
//
//    echo $input;
//
//    // Закрываем соединение с клиентом
//    socket_close($client_socket);
//}
//?>

<?php
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($socket, '127.0.0.1', 8080);
socket_listen($socket);
$client_socket = socket_accept($socket);

for ($i = 0; $i < 1000; $i++) {
    $msg = "message_{$i}";
    socket_write($client_socket, $msg, strlen($msg));
    echo "Сервер сообщает: " . $msg . PHP_EOL. PHP_EOL;

    sleep(3);
}

socket_close($client_socket);
socket_close($socket);
?>
