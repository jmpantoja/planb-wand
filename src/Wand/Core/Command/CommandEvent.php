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

use PlanB\Wand\Core\Action\ActionEvent;
use PlanB\Wand\Core\Logger\Message\LogMessage;

/**
 * Evento que se lanza al tratar un objeto Command.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class CommandEvent extends ActionEvent
{
    /**
     * @var \PlanB\Wand\Core\Command\Command
     */
    private $command;

    /**
     * CommandEvent constructor.
     *
     * @param \PlanB\Wand\Core\Command\Command $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * Devuelve el nombre del evento.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'wand.cmd.execute';
    }

    /**
     * Configura el mensaje de log.
     *
     * @param \PlanB\Wand\Core\Logger\Message\LogMessage $message
     */
    public function configureLog(LogMessage $message): void
    {
        $title = $this->command->getTitle();
        $group = $this->command->getGroup();
        $commandLine = $this->command->getCommandLine();
        $output = $this->command->getOutput();

        $level = $this->command->getLevel();

        $title = sprintf('[%s] Execute %s', $group, $title);

        $message->setTitle($title);
        $message->setLevel($level);

        $message->setVerbose([
            'cmd' => $commandLine,
            'output' => $output,
        ]);
    }

    /**
     * Devuelve el comando.
     *
     * @return \PlanB\Wand\Core\Command\Command
     */
    public function getCommand(): Command
    {
        return $this->command;
    }
}
