<?php

use Workerman\Worker;

require '../vendor/autoload.php';

$wsWorker = new Worker('websocket://0.0.0.0:2346');
$wsWorker->count = 4;

$wsWorker->onConnect = function ($connection) {
    echo "New connection";
};

$wsWorker->onMessage = function ($connection, $data) use($wsWorker) {
    // ON SERVER
    //$request->get();
    //$request->post();
    //$request->header();
    //$request->cookie();
    //$request->session();
    //$request->uri();
    //$request->path();
    //$request->method();
    foreach ($wsWorker->connections as $clientConnection) {
        if ($connection->id !== $clientConnection->id) {
            $clientConnection->send($data);
        }
    }
};

$wsWorker->onClose = function ($connection) {
    echo "Connections close";
};

Worker::runAll();