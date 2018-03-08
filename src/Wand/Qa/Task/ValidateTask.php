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
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ValidateTask extends Task
{

    /**
     * {@inheritdoc}
     */
    public function execute(): LogMessage
    {
        $message = $this->sequence('@composer/validate', '@qa');

        if ($message->isSuccessful()) {
            $message = $this->sequenceFrom($message, '@tdd/unit');
        }
        
        return $message;
    }
}
