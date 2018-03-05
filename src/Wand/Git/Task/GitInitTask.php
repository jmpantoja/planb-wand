<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Git\Task;

use PlanB\Utils\Path\Path;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Task\Task;

/**
 * Inicializa Git.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class GitInitTask extends Task
{
    /**
     * {@inheritdoc}
     */
    public function execute(): LogMessage
    {
        if ($this->isInitialized()) {
            $message = LogMessage::success();
            $this->logger->skip('[Git] Initialized empty Git repository');
        } else {
            $message =$this->run('git');
        }

        return $this->sequenceFrom($message, 'gitignore', 'precommit', 'commitmsg');
    }

    /**
     * Indica si git ya ha sido incializado.
     *
     * @return bool
     */
    private function isInitialized(): bool
    {
        $base = $this->context->getPath('project');
        $path = Path::create($base, '.git');

        return $path->isDirectory();
    }
}
