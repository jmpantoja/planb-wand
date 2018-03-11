<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Docs\Task;

use PlanB\Wand\Core\Git\GitManager;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Task\Task;

/**
 * Actualiza la documentación
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class SamiTask extends Task
{
    /**
     * {@inheritdoc}
     */
    public function execute(): LogMessage
    {

        $message = LogMessage::error();

        $success = false;
        if ($this->run('sami')->isSuccessful()) {
            $path = $this->context->getPath('docs_api');
            $success = $this->getGitManager()->addFilesToStage([$path]);
        }

        if ($success) {
            $message = LogMessage::success();
        }

        return $message;
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
