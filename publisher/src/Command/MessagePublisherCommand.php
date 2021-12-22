<?php

namespace App\Command;

use SykesCottages\Qu\Connector\Queue;
use SykesCottages\Qu\Connector\RabbitMQ;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MessagePublisherCommand extends Command
{
    protected static $defaultName = 'message:publish';

    protected static $defaultDescription = 'Publish a message to the test queue';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rabbitMq = new RabbitMQ('rabbit-1', 5672, 'guest', 'guest');

        $rabbitMq->setQueueOptions(['blockingConsumer' => true]);

        $testingQueue = new Queue('test', $rabbitMq);

        $testingQueue->queueMessage(['example' => rand(1, 10000)]);

        return Command::SUCCESS;
    }
}