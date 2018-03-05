<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Logger\Message;

use MabeEnum\Enum;

/**
 * Tipos de mensaje de log.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 *  @method static MessageType ERROR()
 *  @method static MessageType SUCCESS()
 *  @method static MessageType SKIP()
 *  @method static MessageType INFO()
 */
class MessageType extends Enum
{
    public const ERROR = 0;
    public const SUCCESS = 1;
    public const SKIP = 2;
    public const INFO = 3;

    /**
     * Indica si el mensaje es de tipo info.
     *
     * @return bool
     */
    public function isInfo(): bool
    {
        return $this->is(MessageType::INFO);
    }

    /**
     * Indica si el mensaje es de tipo success.
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->is(MessageType::SUCCESS);
    }

    /**
     * Indica si el mensaje es de tipo skip.
     *
     * @return bool
     */
    public function isSkipped(): bool
    {
        return $this->is(MessageType::SKIP);
    }

    /**
     * Indica si el mensaje es de tipo error.
     *
     * @return bool
     */
    public function isError(): bool
    {
        return $this->is(MessageType::ERROR);
    }
}
