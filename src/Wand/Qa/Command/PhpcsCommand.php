<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Qa\Command;

use PlanB\Utils\Path\Path;
use PlanB\Wand\Core\Command\Command;
use PlanB\Wand\Legacy\Phpcs\CodeSniffer;

/**
 * Ejecuta phpcs
 *
 * @package PlanB\Wand\Qa\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class PhpcsCommand extends Command
{

    /**
     * @var \PlanB\Wand\Legacy\Phpcs\CodeSniffer
     */
    protected $runner;


    /**
     * Ejecuta el comando
     *
     * @return bool
     */
    public function run(): bool
    {

        $this->initialize();
        $tokens = $this->getTokens();

        $exitCode = $this->runMethod($tokens);

        $this->output = $this->getRunner()->getOutput();
        return $exitCode === 0;
    }


    /**
     * Devuelve el objeto CodeSniffer
     *
     * @return \PlanB\Wand\Legacy\Phpcs\CodeSniffer
     */
    public function getRunner(): CodeSniffer
    {
        if (empty($this->runner)) {
            $this->runner = new CodeSniffer();
        }

        return $this->runner;
    }

    /**
     * Asigna el objeto CodeSniffer
     *
     * @param \PlanB\Wand\Legacy\Phpcs\CodeSniffer $runner
     * @return \PlanB\Wand\Qa\Command\PhpcsCommand
     */
    public function setRunner(CodeSniffer $runner): PhpcsCommand
    {
        $this->runner = $runner;
        return $this;
    }

    /**
     * Nos aseguramos de que las clases de codesniffer esten incluidas
     * @codeCoverageIgnore
     */
    protected function initialize(): void
    {
        $base = $this->context->getPath('wand');

        $path = Path::join($base, 'vendor/squizlabs/php_codesniffer/autoload.php');
        include_once $path;
    }

    /**
     * Devuelve los tokens del comando
     * @return string[]
     */
    protected function getTokens(): array
    {
        $tokens = $this->getCommandTokens();
        array_shift($tokens);
        return $tokens;
    }


    /**
     * Ejecuta el método phpcs
     *
     * @param mixed[] $tokens
     * @return int
     */
    protected function runMethod(array $tokens): int
    {
        return $this->getRunner()->runPHPCS($tokens);
    }
}
