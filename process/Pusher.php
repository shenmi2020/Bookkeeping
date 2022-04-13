<?php
namespace process;

use Workerman\Connection\TcpConnection;

class Pusher
{
    public function onConnect(TcpConnection $connection)
    {
        echo "onConnect\n";
    }

    public function onWebSocketConnect(TcpConnection $connection, $http_buffer)
    {
        echo "onWebSocketConnect\n";
    }

    public function onMessage(TcpConnection $connection, $data)
    {
        var_dump(json_encode($data));
        $connection->send($data);
        echo "onMessage\n";
    }

    public function onClose(TcpConnection $connection)
    {
        echo "onClose\n";
    }
}