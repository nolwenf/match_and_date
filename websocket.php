<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require __DIR__ . '/vendor/autoload.php';

    class MyChat implements MessageComponentInterface {
        protected $clients;

        public function __construct() {
            $this->clients = new \SplObjectStorage;
        }

        public function onOpen(ConnectionInterface $conn) {
            $this->clients->attach($conn);
            echo "New connection! ({$conn->resourceId})\n";
        }

        public function onMessage(ConnectionInterface $from, $msg) {
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    $client->send($msg);
                }
            }
        }

        public function onClose(ConnectionInterface $conn) {
            $this->clients->detach($conn);
            echo "Connection {$conn->resourceId} has disconnected\n";
        }

        public function onError(ConnectionInterface $conn, \Exception $e) {
            echo "An error has occurred: {$e->getMessage()}\n";
            $conn->close();
        }
    }
    $server = new \Ratchet\WebSocket\WsServer(new \MyChat());
    $port = 8080;
    $server = \Ratchet\Server\IoServer::factory(
        new \Ratchet\Http\HttpServer(
            new \Ratchet\WebSocket\WsServer(
                new \MyChat()
            )
        ),
        $port
    );
    $server->run();
?>