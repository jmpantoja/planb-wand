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
     * @var \PlanB\Wand\Core\Logger\Message\LogFormat $format
     */
    private $format;

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
     */
    private function __construct(LogFormat $format)
    {
        $this->format = $format;
        $this->type = $format->getType();
        $this->title = [];
        $this->verbose = [];
    }

    /**
     * Asigna el titulo
     *
     * @param string $title
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function setTitle(string $title): LogMessage
    {
        $this->title = $this->format->title($title);
        return $this;
    }

    /**
     * Asigna las lineas de verbose
     *
     * @param string[] $verbose
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function setVerbose(array $verbose): LogMessage
    {
        $this->verbose = $this->format->verbose($verbose);
        return $this;
    }

    /**
     * Añade una linea al verbose
     *
     * @param string $title
     * @param string $body
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function addVerbose(string $title, string $body): LogMessage
    {
        $verbose = $this->format->verbose([$title => $body]);
        $this->verbose = array_merge($this->verbose, $verbose);

        return $this;
    }


    /**
     *  Crea una nueva instancia de mensaje tipo "info"
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public static function info(): LogMessage
    {
        return new self(LogFormat::info());
    }

    /**
     * Crea una nueva instancia de mensaje tipo  "success"
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public static function success(): self
    {
        return new self(LogFormat::success());
    }

    /**
     * Crea una nueva instancia de mensaje tipo  "skip"
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public static function skip(): self
    {
        return new self(LogFormat::skip());
    }


    /**
     * Crea una nueva instancia de mensaje tipo  "error"
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public static function error(): self
    {
        return new self(LogFormat::error());
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
