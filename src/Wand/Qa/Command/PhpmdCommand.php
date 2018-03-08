<?php declare(strict_types=1);

/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Qa\Command;

use PHPMD\RuleSetFactory;
use PHPMD\TextUI\CommandLineOptions;
use PlanB\Wand\Core\Command\Command;
use PlanB\Wand\Legacy\Phpmd\CommandPhpmd;

/**
 * Ejecuta el comando phpmd
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class PhpmdCommand extends Command
{
    /**
     * Ejecuta el comando
     *
     * @return bool
     */
    public function run(): bool
    {
        $tokens = $this->getCommandTokens();

        try {
            $ruleSetFactory = new RuleSetFactory();
            $options = new CommandLineOptions($tokens, $ruleSetFactory->listAvailableRuleSets());
            $command = new CommandPhpmd();

            $exitCode = $command->run($options, $ruleSetFactory);

            $this->output = $command->getOutput();
        } catch (\Throwable $e) {
            $this->output = $e->getMessage();
            $exitCode = CommandPhpmd::EXIT_EXCEPTION;
        }


        return 0 === $exitCode;
    }

    /**
     * Formatea el argumento ruta
     *
     * @param string[] $files
     *
     * @return string
     */
    public function parseModifiedFiles(array $files): string
    {
        return implode(',', $files);
    }
}
