<?php

declare(strict_types=1);

namespace App\Command;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MessagePublisherCommand extends Command
{
    private const QUEUE_NAME = 'test';

    protected static $defaultName = 'message:publish';

    protected static $defaultDescription = 'Publish a message to the test queue';

    protected function execute(InputInterface $input, OutputInterface $output)
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
            $msg = new AMQPMessage('Hello there!');
            $channel->basic_publish($msg, '', self::QUEUE_NAME);

            $channel->close();
            $conn->close();

            echo '[x] Message added to ' . self::QUEUE_NAME . ' queue.' . PHP_EOL;
            return Command::SUCCESS;
        } catch (Exception $e) {
            echo $e->getMessage();
            return Command::FAILURE;
        }
    }
}
