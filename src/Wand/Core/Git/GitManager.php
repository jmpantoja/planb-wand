<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Git;

use PlanB\Utils\Path\Path;
use Symfony\Component\Process\Process;

/**
 * Control del stage de git
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class GitManager
{

    /**
     * @var string
     */
    private $projectPath;

    /**
     * @var null|string[]
     */
    private $whiteList = null;

    /**
     * GitManager constructor.
     *
     * @param string $projectPath
     */
    protected function __construct(string $projectPath)
    {
        $this->projectPath = $projectPath;
    }

    /**
     * Crea una nueva instancia del manager
     *
     * @param string $base
     *
     * @return \PlanB\Wand\Core\Git\GitManager
     */
    public static function create(string $base): self
    {
        return new self($base);
    }

    /**
     * Indica si el directorio cwd esta supervisado por git
     *
     * @return bool
     */
    public function isInitialized(): bool
    {
        return $this->run('git status')->isSuccessful();
    }


    /**
     * Asigna una lista de archivos sobre los que si podemos actuar
     *
     * @param null|string[] $files
     *
     * @return \PlanB\Wand\Core\Git\GitManager
     */
    public function setWhiteList(?array $files): self
    {
        $this->whiteList = $files;

        return $this;
    }


    /**
     * Devuelve los archivos que estan en el stage
     *
     * @return string[]
     */
    public function getStagedFiles(): array
    {

        $command = $this->getCommandLine();
        $output = $this->run($command)->getOutput();

        $files = explode("\n", $output);

        $files = array_filter($files, function ($file) {
            return $this->verifyFile($file);
        });

        return array_values($files);
    }

    /**
     * Indica si un archivo es procesable o no
     *
     * @param string $file
     *
     * @return bool
     */
    private function verifyFile(string $file): bool
    {
        if (empty($file)) {
            return false;
        }

        $verified = 'php' === Path::create($file)->extension();


        if (!is_null($this->whiteList)) {
            $verified = in_array($file, $this->whiteList);
        }

        return $verified;
    }


    /**
     * Indica si hay ficheros en el stage
     *
     * @return bool
     */
    public function hasStagedFiles(): bool
    {
        $files = $this->getStagedFiles();

        return count($files) > 0;
    }

    /**
     * Vuelve a añadir al stage los archivos modificadoso
     *
     * @return bool
     */
    public function reStageFiles(): bool
    {
        $stage = $this->getStagedFiles();

        $success = true;
        foreach ($stage as $file) {
            $success = $success && $this->gitAdd($file);
        }

        return $success;
    }

    /**
     * Añade un archivo al stage de git
     *
     * @param string $file
     *
     * @return bool
     */
    protected function gitAdd(string $file): bool
    {
        $cmd = sprintf('git add %s', $file);

        return $this->run($cmd)->isSuccessful();
    }


    /**
     * Devuelve el comando para ver los ficheros que estan en el stage
     *
     * @return string
     */
    private function getCommandLine(): string
    {

        $against = '4b825dc642cb6eb9a060e54bf8d69288fbee4904';
        if ($this->run('git rev-parse --verify HEAD')->isSuccessful()) {
            $against = 'HEAD';
        }

        return sprintf("git diff-index --cached --name-status %s | egrep '^(A|M)' | awk '{print $2;}'", $against);
    }


    /**
     * Devuelve un proceso despues de ejecutar un comando git
     *
     * @param string $cmd
     *
     * @return \Symfony\Component\Process\Process
     */
    protected function run(string $cmd): Process
    {
        $process = new Process($cmd, $this->projectPath);
        $process->run();

        return $process;
    }
}
