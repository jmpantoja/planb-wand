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
 * Formatea un mensaje de log.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
final class LogFormat
{
    public const PADDING_LENGTH = 80;

    /**
     * @var \PlanB\Wand\Core\Logger\Message\MessageType
     */
    private $type;

    /**
     * @var string
     */
    private $color;

    /**
     * @var null|string
     */
    private $resume;

    /**
     * LogFormat constructor.
     *
     * @param \PlanB\Wand\Core\Logger\Message\MessageType $type
     * @param string $color
     * @param null|string $resume
     */
    private function __construct(MessageType $type, string $color, ?string $resume = null)
    {
        $this->type = $type;
        $this->color = $color;
        $this->resume = $resume;
    }

    /**
     * Crea una nueva instancia, tipo info.
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogFormat
     */
    public static function info(): self
    {
        return new static(MessageType::INFO(), 'default');
    }

    /**
     * Crea una nueva instancia, tipo success.
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogFormat
     */
    public static function success(): self
    {
        return new static(MessageType::SUCCESS(), 'green', 'OK');
    }

    /**
     * Crea una nueva instancia, tipo skip.
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogFormat
     */
    public static function skip(): self
    {
        return new static(MessageType::SKIP(), 'yellow', 'SKIP');
    }

    /**
     * Crea una nueva instancia, tipo skip.
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogFormat
     */
    public static function error(): self
    {
        return new static(MessageType::ERROR(), 'red', 'ERROR');
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
     * Devuelve el titulo debidamente formateado.
     *
     * @param string $title
     *
     * @return string[]
     */
    public function title(string $title): array
    {
        $lines = [];

        $lines[] = $this->format($title);

        return $lines;
    }

    /**
     * Devuelve el titulo del mensaje, con el padding  y el resume.
     *
     * @param string $title
     *
     * @return string
     */
    private function format(string $title): string
    {
        $points = $this->getPoints($title);

        $title = $this->colorize($title);
        $padding = $this->colorize($points);
        $resume = $this->colorize($this->resume);

        return sprintf('%s%s%s', $title, $padding, $resume);
    }

    /**
     * Devuelve el número correcto de puntos para el padding.
     *
     * @param string $title
     *
     * @return null|string
     */
    private function getPoints(string $title): ?string
    {
        if (is_null($this->resume)) {
            return null;
        }
        $length = self::PADDING_LENGTH - strlen($title);

        if ($length <= 0) {
            return null;
        }

        $points = str_repeat('.', $length);

        return $points;
    }

    /**
     * Colorea un texto.
     *
     * @param null|string $text
     *
     * @return string
     */
    private function colorize(?string $text): string
    {
        $colorized = '';
        if (!is_null($text)) {
            $colorized = sprintf('<fg=%s>%s</>', $this->color, $text);
        }

        return $colorized;
    }

    /**
     * Devuelve el verbose debidamente formateado.
     *
     * @param string[] $verbose
     *
     * @return string[]
     */
    public function verbose(array $verbose): array
    {
        $lines = [];

        foreach ($verbose as $head => $value) {
            $body = [];
            foreach ($this->toLines($value) as $line) {
                $body[] = $line;
            }

            $lines = array_merge($lines, $this->formatVerbose($head, $body));
        }

        return $lines;
    }

    /**
     * Devuelve las lineas de verbose, ordenadas y formateadas.
     *
     * @param string $key
     * @param string[] $body
     *
     * @return string[]
     */
    private function formatVerbose(string $key, array $body): array
    {
        $key = sprintf('%s:', strtoupper($key));
        $head = $this->colorize($key);

        $total = count(array_filter($body));

        $lines = [];

        if ($total === 1) {
            $lines[] = sprintf('%s %s', $head, implode('', $body));
        } elseif ($total > 1) {
            $lines[] = $head;

            $lines = array_merge($lines, $body);
        }

        $lines[] = "\n";

        return (array)$lines;
    }

    /**
     * Convierte una linea en un array.
     *
     * @param string[]|string $value
     *
     * @return string[]
     */
    private function toLines($value): array
    {
        $lines = $value;

        if (is_string($value)) {
            $lines = $this->toLines(explode("\n", $value));
        }

        return $lines;
    }
}
