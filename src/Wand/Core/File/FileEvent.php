<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\File;

use PlanB\Wand\Core\Action\ActionEvent;
use PlanB\Wand\Core\Logger\Message\LogMessage;

/**
 * Evento que se lanza al tratar un objeto File.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class FileEvent extends ActionEvent
{
    /**
     * @var \PlanB\Wand\Core\File\File
     */
    private $file;

    /**
     * FileEvent constructor.
     *
     * @param \PlanB\Wand\Core\File\File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Devuelve el nombre del evento.
     *
     * @return string
     */
    public function getName(): string
    {
        $action = $this->file->getAction();

        return sprintf('wand.file.%s', $action);
    }

    /**
     * Configura el mensaje de log.
     *
     * @param \PlanB\Wand\Core\Logger\Message\LogMessage $message
     */
    public function configureLog(LogMessage $message): void
    {
        $target = $this->file->getTarget();
        $action = $this->file->getAction();
        $group = $this->file->getGroup();
        $level = $this->file->getLevel();

        $title = sprintf('[%s] %s file %s', $group, ucfirst($action), $target);

        $message->setLevel($level);
        $message->setTitle($title);
        $message->setVerbose([
            'path' => $this->file->getPath(),
        ]);
    }

    /**
     * Devuelve el objeto File.
     *
     * @return \PlanB\Wand\Core\File\File
     */
    public function getFile(): File
    {
        return $this->file;
    }
}
