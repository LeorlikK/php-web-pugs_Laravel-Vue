<?php
require '../vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;

class MyChat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        echo "111";
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        echo "222";
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "333";
        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        echo "444";
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "555";
        $conn->close();
    }
}



$server = IoServer::factory(
    new MyChat(),
    2346
);

$server->run();


//$app = new Ratchet\App('localhost', 8080);
//$app->route('/chat', new MyChat, array('*'));
//$app->route('/echo', new Ratchet\Server\EchoServer, array('*'));
//$app->run();
?>
