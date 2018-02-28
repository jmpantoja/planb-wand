<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Command;

use PlanB\Utils\Path\Path;
use PlanB\Wand\Core\Action\Action;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Modela un commando
 *
 * @package PlanB\Wand\Core\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class Command extends Action
{
    /**
     * @var string $group
     */
    private $group;

    /**
     * @var string $pattern
     */
    private $pattern;

    /**
     * @var string $cwd
     */
    private $cwd;


    /**
     * @var string $output ;
     */
    private $output = '';

    /**
     * Command constructor.
     *
     * @param mixed[] $params
     */
    private function __construct(array $params)
    {
        $this->group = (string)$params['group'];
        $this->pattern = (string)$params['pattern'];
        $this->cwd = (string)$params['cwd'];
    }

    /**
     * Crea una nueva instancia
     *
     * @param mixed[] $options
     * @return \PlanB\Wand\Core\Command\Command
     */
    public static function create(array $options): self
    {
        $params = $options['params'] ?? [];
        $params['group'] = $options['group'];

        $params = CommandOptions::create()
            ->resolve($params);

        return new self($params);
    }

    /**
     * Devuelve el comando a ejecutar
     *
     * @return string
     */
    public function getCommandLine(): string
    {

        $cwd = $this->getCwd();
        $commandLine = Path::join($cwd, $this->pattern);

        $replacements = [
            '%project%' => $this->context->getPath('project'),
            '%target%' => $this->context->getPath('target'),
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $commandLine);
    }

    /**
     * Devuelve la linea de comandos en formato reducido
     *
     * @return string
     */
    public function getTitle(): string
    {

        $filesystem = new Filesystem();
        $cwd = $this->getCwd();

        $cwd = $filesystem->makePathRelative($cwd, realpath('.'));

        $title = sprintf('%s%s', $cwd, $this->pattern);
        $title = preg_replace('/%.*%/', '', $title);

        return trim($title);
    }

    /**
     * Devuelve el directorio de trabajo
     *
     * @return string
     */
    public function getCwd(): string
    {
        return $this->context->getPath($this->cwd);
    }

    /**
     * Ejecuta el comando
     *
     * @return bool
     */
    public function run(): bool
    {
        $commandLine = $this->getCommandLine();

        $process = new Process($commandLine);
        $process->run();

        $this->buildOutput($process);

        return $this->isSuccessful($process);
    }

    /**
     * Indica si el comando se ha ejecutado con exito
     *
     * @param \Symfony\Component\Process\Process $process
     * @return bool
     */
    protected function isSuccessful(Process $process): bool
    {
        return $process->isSuccessful();
    }

    /**
     * Calcula la salida del comando
     *
     * @param \Symfony\Component\Process\Process $process
     */
    protected function buildOutput(Process $process): void
    {
        if ($process->isSuccessful()) {
            $this->output = $this->getSuccessOutput($process);
        } else {
            $this->output = $this->getErrorOutput($process);
        }
    }

    /**
     * Devuelve la salida del comando en caso de exito
     *
     * @param \Symfony\Component\Process\Process $process
     * @return string
     */
    protected function getSuccessOutput(Process $process): string
    {
        return $process->getOutput();
    }

    /**
     * Devuelve la salida del comando en caso de error
     *
     * @param \Symfony\Component\Process\Process $process
     * @return string
     */
    protected function getErrorOutput(Process $process): string
    {
        return $process->getErrorOutput();
    }


    /**
     * Devuelve la salida
     *
     * @return string
     */
    public function getOutput(): string
    {
        return $this->output;
    }

    /**
     * Devuelve el grupo de acciones a la que pertenece este comando
     *
     * @return string
     */
    public function getGroup(): string
    {
        return ucfirst($this->group);
    }
}
