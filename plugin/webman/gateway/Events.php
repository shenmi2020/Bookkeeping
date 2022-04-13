<?php

namespace plugin\webman\gateway;

use GatewayWorker\Lib\Gateway;

class Events
{
    public static function onWorkerStart($worker)
    {

    }

    public static function onConnect($client_id)
    {
        echo "onConnect\n".$client_id;
        echo PHP_EOL;
    }

    public static function onWebSocketConnect($client_id, $data)
    {
        echo "onWebSocketConnect\n".$client_id;
        echo PHP_EOL;
    }

    public static function onMessage($client_id, $message)
    {
        Gateway::sendToClient($client_id, "receive message $message");
    }

    public static function onClose($client_id)
    {

    }

}
