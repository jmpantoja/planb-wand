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

use Overtrue\PHPLint\Console\Application;
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Ejecuta código
 *
 * @package PlanB\Wand\Core\Runner
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class SymfonyCommand extends Command
{

    /**
     * @var \Symfony\Component\Console\Command\Command
     */
    private $command;

    /**
     * Command constructor.
     *
     * @param mixed[] $params
     */
    protected function __construct(array $params)
    {
        parent::__construct($params);
        $command = $params['command'];

        $this->command = new $command();
    }

    /**
     * Crea una nueva instancia.
     *
     * @param mixed[] $options
     *
     * @return \PlanB\Wand\Core\Command\Command
     */
    public static function create(array $options): Command
    {
        $params = $options['params'] ?? [];
        $params['group'] = $options['group'];

        $params = CommandOptions::create('symfony')
            ->resolve($params);

        return new static($params);
    }

    /**
     * @inheritdoc
     *
     * @return bool
     */
    public function run(): bool
    {
        $application = new Application();

        $command = $this->getCommand();
        $tokens = $this->getCommandTokens();

        $input = new ArgvInput($tokens, $command->getDefinition());
        $output = new BufferedOutput();

        $command->setApplication($application);

        $status = $command->run($input, $output);

        $this->output = $output->fetch();
        return $status === 0;
    }



    /**
     * Devuelve el comando
     *
     * @return \Symfony\Component\Console\Command\Command
     */
    public function getCommand(): ConsoleCommand
    {
        return $this->command;
    }
}
