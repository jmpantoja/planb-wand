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
 * Representa un mensaje mostrado por consola.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
final class LogMessage
{
    private const TAB = '  ';

    /**
     * @var int
     */
    private $level = 0;

    /**
     * @var \PlanB\Wand\Core\Logger\Message\LogFormat
     */
    private $format;

    /**
     * @var \PlanB\Wand\Core\Logger\Message\MessageType
     */
    private $type;

    /**
     * @var string[]
     */
    private $title;

    /**
     * @var string[]
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
     * Asigna el nivel en la jerarquia de logs.
     *
     * @param int $level
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function setLevel(int $level): LogMessage
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Asigna el titulo.
     *
     * @param string $title
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function setTitle(string $title): LogMessage
    {
        $this->title = $this->format->title($title);

        return $this;
    }

    /**
     * Asigna las lineas de verbose.
     *
     * @param string[] $verbose
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function setVerbose(array $verbose): LogMessage
    {
        $this->verbose = $this->format->verbose($verbose);

        return $this;
    }

    /**
     * Añade una linea al verbose.
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
     *  Crea una nueva instancia de mensaje tipo "info".
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public static function info(): LogMessage
    {
        return new self(LogFormat::info());
    }

    /**
     * Crea una nueva instancia de mensaje tipo  "success".
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public static function success(): self
    {
        return new self(LogFormat::success());
    }

    /**
     * Crea una nueva instancia de mensaje tipo  "skip".
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public static function skip(): self
    {
        return new self(LogFormat::skip());
    }

    /**
     * Crea una nueva instancia de mensaje tipo  "error".
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public static function error(): self
    {
        return new self(LogFormat::error());
    }

    /**
     * Devuelve el tipo de mensaje.
     *
     * @return \PlanB\Wand\Core\Logger\Message\MessageType
     */
    public function getType(): MessageType
    {
        return $this->type;
    }

    /**
     * Indica si el mensaje es de tipo info.
     *
     * @return bool
     */
    public function isInfo(): bool
    {
        return $this->type->is(MessageType::INFO);
    }

    /**
     * Indica si el mensaje es de tipo success.
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->type->is(MessageType::SUCCESS);
    }

    /**
     * Indica si el mensaje es de tipo skip.
     *
     * @return bool
     */
    public function isSkipped(): bool
    {
        return $this->type->is(MessageType::SKIP);
    }

    /**
     * Indica si el mensaje es de tipo error.
     *
     * @return bool
     */
    public function isError(): bool
    {
        return $this->type->is(MessageType::ERROR);
    }

    /**
     * Devuelve el mensage en forma de lineas de texto.
     *
     * @return string[]
     */
    public function parse(): array
    {
        $lines = $this->addTabs($this->title);

        if ($this->type->is(MessageType::ERROR)) {
            $lines = $this->parseVerbose();
        }

        return $lines;
    }

    /**
     * Añade tabulaciones al principio de cada linea.
     *
     * @param string[] $lines
     *
     * @return string[]
     */
    private function addTabs(array $lines): array
    {
        $tabs = str_repeat(self::TAB, $this->level);

        return array_map(function (string $line) use ($tabs) {
            return sprintf('%s%s', $tabs, trim($line));
        }, $lines);
    }

    /**
     * Devuelve el mensage en forma de lineas de texto.
     *
     * @return string[]
     */
    public function parseVerbose(): array
    {
        $lines = array_merge($this->title, $this->verbose);

        return $this->addTabs($lines);
    }

    /**
     * Devuelve el código de error
     *
     * @return int
     */
    public function getExitCode(): int
    {
        $type = $this->getType();

        $exitCode = 1;
        if (!$type->isError()) {
            $exitCode = 0;
        }

        return $exitCode;
    }


    /**
     * Combina el tipo de dos mensajes, considerando la jerarquia:
     * 1. error
     * 2. skip
     * 3. success
     *
     * @param \PlanB\Wand\Core\Logger\Message\LogMessage $message
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function mergeType(LogMessage $message): self
    {
        if (!$this->isError()) {
            if (!$message->isSuccessful() && !$message->isInfo()) {
                $this->type = $message->getType();
            }
        }

        return $this;
    }
}
