<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Tdd\Task;

use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Task\Task;

class CodeceptTask extends Task
{
    /**
     * {@inheritdoc}
     */
    public function execute(): LogMessage
    {
        $codeception = $this->file('codeception');

        if ($codeception->exists()) {
            $message = LogMessage::skip();
            $this->logger->skip('[Tdd] Codeception is already installed in this directory');
        } else {
            $message = $this->sequence('codecept_bootstrap', 'codeception');
        }

        return $this->sequenceFrom($message, 'unit_bootstrap', 'acceptance_bootstrap', 'functional_bootstrap');
    }
}
