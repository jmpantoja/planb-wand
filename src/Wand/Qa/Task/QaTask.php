<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Qa\Task;

use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Task\Task;

/**
 * Quality Assurance
 *
 * @package PlanB\Wand\Qa\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class QaTask extends Task
{

    /**
     * {@inheritdoc}
     */
    public function execute(): LogMessage
    {
        $message = $this->sequence('lint', 'phpcpd', 'phpmd');

        if ($this->run('phpcbf')->isError()) {
            $message = $this->run('phpcs');
        }

        if ($this->hasStagedFiles()) {
            $message = $this->sequenceFrom($message, 'restage');
        }

        return $message;
    }

    /**
     * Indica si hay ficheros en el stage
     *
     * @return bool
     */
    private function hasStagedFiles(): bool
    {
        $manager = $this->context->getGitManager();

        return $manager->hasStagedFiles();
    }
}
