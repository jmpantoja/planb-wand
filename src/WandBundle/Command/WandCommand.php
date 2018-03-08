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
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Comando wand.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class WandCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('wand')
            ->addArgument('task', InputArgument::REQUIRED, 'Nombre de la tarea')
            ->addArgument('path', InputArgument::OPTIONAL, 'Ruta de la raiz del proyecto');
    }

    /**
     * {@inheritdoc}
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output

     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->initPaths($input);
        $this->initConsole($input, $output);

        $this->getContextManager()->execute();

        $taskName = $input->getArgument('task');

        return $this->getTaskManager()->executeByName($taskName);
    }

    /**
     * Indica al pathManager cual es la ruta raiz del proyecto.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     */
    private function initPaths(InputInterface $input): void
    {
        $projectDir = $input->getArgument('path');
        $this->getPathManager()->build($projectDir);
    }

    /**
     * Prepara una tarea para ser ejecutada.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    private function initConsole(InputInterface $input, OutputInterface $output): void
    {
        $helperSet = $this->getHelperSet();

        $consoleManager = ConsoleManager::create($input, $output, $helperSet);

        $dispatcher = $this->getEventDispatcher();
        $dispatcher->addSubscriber($consoleManager);
    }
}
