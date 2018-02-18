<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Logger;

/**
 * Representa un mensaje mostrado por consola
 *
 * @package PlanB\Wand\Core\Logger
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
final class LogMessage
{

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
     * @param string[] $title
     * @param string[] $verbose
     */
    private function __construct(array $title, array $verbose = [])
    {
        $this->title = $title;

        $this->verbose = $verbose;
    }


    public static function info(string $title): LogMessage
    {
        $format = LogFormat::info();
        $title = $format->title($title);

        return new self($title);
    }

    /**
     * Crea una nueva instancia de mensaje "success"
     *
     * @param string $title
     * @param string[] $verbose
     * @return \PlanB\Wand\Core\Logger\LogMessage
     */
    public static function success(string $title, array $verbose = []): self
    {
        $format = LogFormat::success();

        $title = $format->title($title);
        $verbose = $format->verbose($verbose);

        return new self($title, $verbose);
    }

    /**
     * Crea una nueva instancia de mensaje "skip"
     *
     * @param string $title
     * @param string[] $verbose
     * @return \PlanB\Wand\Core\Logger\LogMessage
     */
    public static function skip(string $title, array $verbose = []): self
    {
        $format = LogFormat::skip();

        $title = $format->title($title);
        $verbose = $format->verbose($verbose);

        return new self($title, $verbose);
    }


    /**
     * Crea una nueva instancia de mensaje "error"
     *
     * @param string $title
     * @param string[] $verbose
     * @return \PlanB\Wand\Core\Logger\LogMessage
     */
    public static function error(string $title, array $verbose = []): self
    {
        $format = LogFormat::error();

        $title = $format->title($title);
        $verbose = $format->verbose($verbose);

        $lines = array_merge($title, $verbose);

        return new self($lines);
    }

    /**
     * Devuelve el mensage en forma de lineas de texto
     *
     * @return string[]
     */
    public function parse(): array
    {
        return $this->title;
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
