<?php

namespace App\Command;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MessageConsumer extends Command
{
    private const QUEUE_NAME = 'test';
    private AMQPChannel $channel;
    protected static $defaultName        = 'queue:consume';
    protected static $defaultDescription = 'consume the default queue';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->channel = $this->openChannel();

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $this->consume();

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

        return Command::SUCCESS;
    }

    /**
     * @return AMQPChannel
     */
    private function openChannel(): AMQPChannel
    {
        $conn = new AMQPStreamConnection(
            getenv('RABBIT_HOST'),
            getenv('RABBIT_PORT'),
            getenv('RABBIT_USER'),
            getenv('RABBIT_PASSWORD'),
        );

        $channel = $conn->channel();
        $channel->queue_declare(
            queue:       self::QUEUE_NAME,
            auto_delete: false
        );

        return $channel;
    }

    /**
     * @return void
     */
    private function consume(): void
    {
        $callback = function ($msg): void {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $this->channel->basic_consume(
            queue:    self::QUEUE_NAME,
            no_ack:   true,
            callback: $callback
        );
    }
}
