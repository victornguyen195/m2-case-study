<?php

declare(strict_types=1);

namespace Amasty\JetOptimizer\Console\Command\ImageOptimizer;

use Amasty\JetOptimizer\Console\Command\ImageOptimizer\Operation\Optimize;
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OptimizeCommand extends ConsoleCommand
{
    const COMMAND_NAME = 'amastyjet:image:optimize';

    /**
     * @var Optimize
     */
    private $optimizeCommand;

    public function __construct(
        Optimize $optimizeCommand,
        $name = null
    ) {
        $this->optimizeCommand = $optimizeCommand;

        parent::__construct($name);
    }

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription('Run image optimization script.');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        return $this->optimizeCommand->execute($input, $output);
    }
}
