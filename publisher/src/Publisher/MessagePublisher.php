<?php

declare(strict_types=1);

namespace App\Publisher;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MessagePublisher
{
    private const QUEUE_NAME = 'test';
    private AMQPStreamConnection $conn;
    private AMQPChannel $channel;

    public function sendMessage(array $message): void
    {
        try {
            $this->channel = $this->connect();

            $this->channel->queue_declare(
                queue:       self::QUEUE_NAME,
                auto_delete: false
            );
            $msg = new AMQPMessage(json_encode($message));
            $this->channel->basic_publish(
                msg:         $msg,
                routing_key: self::QUEUE_NAME
            );

            $this->closeConnection();

            echo '[x] Message added to ' . self::QUEUE_NAME . ' queue.' . PHP_EOL;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function connect(): AMQPChannel
    {
        $this->conn = new AMQPStreamConnection(
            'localhost',
            '5672',
            'guest',
            'guest'
        );

        return $this->conn->channel();
    }

    /**
     * @throws Exception
     */
    private function closeConnection(): void
    {
        $this->channel->close();
        $this->conn->close();
    }
}
