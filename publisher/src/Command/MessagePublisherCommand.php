<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MessagePublisherCommand extends Command
{
    protected static $defaultName = 'message:publish';

    protected static $defaultDescription = 'Publish a message to the test queue';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return Command::SUCCESS;
    }
}