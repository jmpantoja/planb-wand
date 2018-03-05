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
use Symfony\Component\Process\Process;

class SystemCommand extends Command
{

    /**
     * @var string
     */
    private $cwd;

    /**
     * Command constructor.
     *
     * @param mixed[] $params
     */
    protected function __construct(array $params)
    {
        parent::__construct($params);
        $this->cwd = (string)$params['cwd'];
    }

    /**
     * @inheritdoc
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
     * @inheritDoc
     */
    public function getCommandLine(): string
    {
        $commandLine = parent::getCommandLine();

        $cwd = $this->getCwd();
        if (!empty($cwd)) {
            $commandLine = Path::join($cwd, $commandLine);
        }
        return $commandLine;
    }


    /**
     * Devuelve el directorio de trabajo.
     *
     * @return null|string
     */
    public function getCwd(): ?string
    {
        if (empty($this->cwd)) {
            return null;
        }

        return $this->context->getPath($this->cwd);
    }


    /**
     * Indica si el comando se ha ejecutado con exito.
     *
     * @param \Symfony\Component\Process\Process $process
     *
     * @return bool
     */
    protected function isSuccessful(Process $process): bool
    {
        return $process->isSuccessful();
    }

    /**
     * Calcula la salida del comando.
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
     * Devuelve la salida del comando en caso de exito.
     *
     * @param \Symfony\Component\Process\Process $process
     *
     * @return string
     */
    protected function getSuccessOutput(Process $process): string
    {
        return $process->getOutput();
    }

    /**
     * Devuelve la salida del comando en caso de error.
     *
     * @param \Symfony\Component\Process\Process $process
     *
     * @return string
     */
    protected function getErrorOutput(Process $process): string
    {
        $output = $process->getErrorOutput();

        if (empty($output)) {
            $output = $process->getOutput();
        }

        return $output;
    }
}
