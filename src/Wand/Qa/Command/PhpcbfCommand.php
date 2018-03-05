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

/**
 * Ejecuta phpccbf
 * @package PlanB\Wand\Qa\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class PhpcbfCommand extends PhpcsCommand
{

    /**
     * Ejecuta el método phpcs
     *
     * @param mixed[] $tokens
     * @return int
     */
    protected function runMethod(array $tokens): int
    {

        $exitCode = $this->getRunner()->runPHPCBF($tokens);
        $this->output = '';
        return $exitCode;
    }
}
