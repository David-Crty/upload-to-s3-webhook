<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class AppCommand
 * @package App
 */
class UploadCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('upload')
            ->setDescription('upload a folder or a file')
            ->addArgument('path', InputArgument::REQUIRED, 'path of the file or the folder')
        ;
    }
    
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}