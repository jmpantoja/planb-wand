<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Composer\Task;

use PlanB\Utils\Path\Path;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Task\Task;

/**
 * Actualiza composer.json si es necesario.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ComposerTask extends Task
{
    /**
     * {@inheritdoc}
     */
    public function execute(): LogMessage
    {
        if (!$this->isUpdatable()) {
            return LogMessage::skip();
        }

        $this->logger->info('wait while composer is updated...');
        return $this->run('update');
    }

    /**
     * Indica si es necesario actualizar composer.json.
     *
     * @return bool
     */
    private function isUpdatable(): bool
    {
        $lockExists = $this->lockExists();
        $valid = $this->run('validate')->isSuccessful();

        return !$lockExists || !$valid;
    }

    /**
     * Indica si existe el fichero composer.lock.
     *
     * @return bool
     */
    private function lockExists(): bool
    {
        $base = $this->context->getPath('project');

        return Path::create($base, 'composer.lock')->exists();
    }
}
