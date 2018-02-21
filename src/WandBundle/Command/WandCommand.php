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

use PlanB\Wand\Core\Task\TaskInterface;
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
        $onlyStaged = $input->getOption('only-staged');

        $this->initPaths($input);

        $task = $this->buildTask($input, $output);
        $task->launch();
    }

    /**
     * Indica al pathManager cual es la ruta raiz del proyecto
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     */
    private function initPaths(InputInterface $input): void
    {
        $projectDir = $input->getArgument('path');
        $this->getPathManager()->build($projectDir);
    }

    /**
     * Prepara una tarea para ser ejecutada
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    private function buildTask(InputInterface $input, OutputInterface $output): TaskInterface
    {
        $taskName = $input->getArgument('task');

        $helperSet = $this->getHelperSet();

        $consoleManager = ConsoleManager::create($input, $output, $helperSet);

        $dispatcher = $this->getEventDispatcher();
        $dispatcher->addSubscriber($consoleManager);

        $task = $this->getTaskManager()->get($taskName);

        $task->setName($taskName);
        $task->setEventDispatcher($dispatcher);
        $task->setLogger($this->getLogger());

        return $task;
    }
}
