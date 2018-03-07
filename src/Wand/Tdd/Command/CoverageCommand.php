<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Tdd\Command;

use PlanB\Wand\Core\Command\SystemCommand;
use Symfony\Component\Process\Process;

class CoverageCommand extends SystemCommand
{
    public const COVERAGE_LEVEL = 80;

    /**
     * Indica si el comando se ha ejecutado con exito.
     *
     * @param \Symfony\Component\Process\Process $process
     * @return bool
     */
    protected function isSuccessful(Process $process): bool
    {
        $success = $process->isSuccessful();

        foreach (['Lines', 'Methods', 'Classes'] as $prefix) {
            $coverage = $this->findCoverage($prefix);
            $isEnough = self::COVERAGE_LEVEL <= $coverage;
            $success = $success && $isEnough;
        }

        return $success;
    }

    /**
     * Devuelve el coverage cubierto para cada tipo de elemento
     *
     * @param string $prefix
     * @return float
     */
    private function findCoverage(string $prefix): float
    {
        $pattern = sprintf('/%s: (.*)%% \(/', $prefix);
        $output = $this->getOutput();
        $matches = [];

        $coverage = 0;
        if (preg_match($pattern, $output, $matches)) {
            $coverage = (float)$matches[1];
        }

        return $coverage;
    }
}
