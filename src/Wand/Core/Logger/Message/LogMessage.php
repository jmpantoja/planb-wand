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

/**
 * Representa un mensaje mostrado por consola
 *
 * @package PlanB\Wand\Core\Logger\Message
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
final class LogMessage
{

    /**
     * @var \PlanB\Wand\Core\Logger\Message\MessageType $type
     */
    private $type;

    /**
     * @var string[] $title
     */
    private $title;

    /**
     * @var string[] $verbose
     */
    private $verbose;

    /**
     * LogMessage constructor.
     *
     * @param \PlanB\Wand\Core\Logger\Message\LogFormat $format
     * @param string $title
     * @param string[] $verbose
     */
    private function __construct(LogFormat $format, string $title, array $verbose = [])
    {
        $this->type = $format->getType();
        $this->title = $format->title($title);
        $this->verbose = $format->verbose($verbose);
    }


    /**
     *  Crea una nueva instancia de mensaje tipo "info"
     *
     * @param string $title
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public static function info(string $title): LogMessage
    {
        $format = LogFormat::info();
        return new self($format, $title);
    }

    /**
     * Crea una nueva instancia de mensaje tipo  "success"
     *
     * @param string $title
     * @param string[] $verbose
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public static function success(string $title, array $verbose = []): self
    {
        $format = LogFormat::success();
        return new self($format, $title, $verbose);
    }

    /**
     * Crea una nueva instancia de mensaje tipo  "skip"
     *
     * @param string $title
     * @param string[] $verbose
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public static function skip(string $title, array $verbose = []): self
    {
        $format = LogFormat::skip();
        return new self($format, $title, $verbose);
    }


    /**
     * Crea una nueva instancia de mensaje tipo  "error"
     *
     * @param string $title
     * @param string[] $verbose
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public static function error(string $title, array $verbose = []): self
    {
        $format = LogFormat::error();
        return new self($format, $title, $verbose);
    }

    /**
     * Devuelve el tipo de mensaje
     *
     * @return \PlanB\Wand\Core\Logger\Message\MessageType
     */
    public function getType(): MessageType
    {
        return $this->type;
    }

    /**
     * Indica si el mensaje es de tipo info
     *
     * @return bool
     */
    public function isInfo(): bool
    {
        return $this->type->is(MessageType::INFO);
    }


    /**
     * Indica si el mensaje es de tipo success
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->type->is(MessageType::SUCCESS);
    }


    /**
     * Indica si el mensaje es de tipo skip
     *
     * @return bool
     */
    public function isSkipped(): bool
    {
        return $this->type->is(MessageType::SKIP);
    }


    /**
     * Indica si el mensaje es de tipo error
     *
     * @return bool
     */
    public function isError(): bool
    {
        return $this->type->is(MessageType::ERROR);
    }


    /**
     * Devuelve el mensage en forma de lineas de texto
     *
     * @return string[]
     */
    public function parse(): array
    {

        $lines = $this->title;
        if ($this->type->is(MessageType::ERROR)) {
            $lines = $this->parseVerbose();
        }

        return $lines;
    }

    /**
     * Devuelve el mensage en forma de lineas de texto
     *
     * @return string[]
     */
    public function parseVerbose(): array
    {
        return array_merge($this->title, $this->verbose);
    }
}
