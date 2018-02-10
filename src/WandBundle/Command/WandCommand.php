<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\WandBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Comando wand
 *
 * @package PlanB\WandBundle\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class WandCommand extends BaseCommand
{

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('wand')
            ->addArgument('task', InputArgument::REQUIRED, 'Nombre de la tarea')
            ->addArgument('path', InputArgument::OPTIONAL, 'Ruta de la raiz del proyecto')
            ->addOption('only-staged', null, InputOption::VALUE_NONE, 'aplicar solo al stage de git');
    }

    /**
     * @inheritdoc
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $taskName = $input->getArgument('task');
        $projectDir = $input->getArgument('path');
        $onlyStaged = $input->getOption('only-staged');

        $this->getAppManager()->build($projectDir);
        $this->getTaskManager()->run($taskName, $onlyStaged);
    }
}
