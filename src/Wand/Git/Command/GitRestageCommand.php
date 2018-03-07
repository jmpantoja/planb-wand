<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Git\Command;

use PlanB\Wand\Core\Command\Command;
use PlanB\Wand\Core\Git\GitManager;

/**
 * Vuelve a añadir al stage los archivos modificados
 *
 * @package PlanB\Wand\Git\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class GitRestageCommand extends Command
{

    /**
     * Ejecuta el comando
     *
     * @return bool
     */
    public function run(): bool
    {
        $manager = $this->getGitManager();
        return $manager->reStageFiles();
    }

    /**
     * @inheritdoc
     * @return string
     */
    public function getCommandLine(): string
    {
        $manager = $this->getGitManager();
        $files = $manager->getStagedFiles();

        return sprintf('git add %s', implode(' ', $files));
    }

    /**
     * Devuelve el gestor de Git
     *
     * @return \PlanB\Wand\Core\Git\GitManager
     */
    private function getGitManager(): GitManager
    {
        return $this->context->getGitManager();
    }
}
