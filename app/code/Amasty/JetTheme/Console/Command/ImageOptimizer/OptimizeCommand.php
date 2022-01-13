<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Console\Command\ImageOptimizer;

use Amasty\JetTheme\Console\Command\ImageOptimizer\Operation\Optimize;
use Symfony\Component\Console\Command\Command as ConsoleCommand;

/**
 * @deprecared 1.12.0
 */
class OptimizeCommand extends ConsoleCommand
{
    public function __construct(
        Optimize $optimizeCommand,
        $name = 'amasty:jetoptimizer:deprecated'
    ) {
        parent::__construct('amasty:jetoptimizer:deprecated');
    }
}
