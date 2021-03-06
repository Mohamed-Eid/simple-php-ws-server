<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Socket implements MessageComponentInterface {

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {

        // Store the new connection in $this->clients
        $this->clients->attach($conn);
        // var_dump($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        $data = [
            'from' => $from->resourceId,
            'msg' => $msg,
        ];
        print_r($data['msg']);

        foreach ( $this->clients as $client ) {

            // if ( $from->resourceId == $client->resourceId ) {
            //     continue;
            // }

            // $client->send( "Client $from->resourceId said $msg" );
            $client->send( json_encode($data));
        }
    }

    public function onClose(ConnectionInterface $conn) {
    
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        
    }
}