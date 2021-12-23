<?php

declare(strict_types=1);

namespace App\Publisher;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MessagePublisher
{
    private const QUEUE_NAME = 'test';

    public function sendMessage(array $message)
    {
        try {
            $conn = new AMQPStreamConnection(
                'localhost',
                '5672',
                'guest',
                'guest'
            );

            $channel = $conn->channel();

            $channel->queue_declare(self::QUEUE_NAME, false, false, false, false);
            $msg = new AMQPMessage(json_encode($message));
            $channel->basic_publish($msg, '', self::QUEUE_NAME);

            $channel->close();
            $conn->close();

            echo '[x] Message added to ' . self::QUEUE_NAME . ' queue.' . PHP_EOL;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
