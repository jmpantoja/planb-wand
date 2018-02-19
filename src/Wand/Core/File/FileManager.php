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

use PlanB\Wand\Core\Logger\LogMessage;

/**
 * Gestiona los archivos
 *
 * @package PlanB\Wand\Core\File
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class FileManager
{

    /**
     * @var \Twig_Environment $twig
     */
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Crea / Elimina un archivo
     *
     * @param \PlanB\Wand\Core\File\File $file
     * @return \PlanB\Wand\Core\Logger\LogMessage
     */
    public function execute(File $file): LogMessage
    {

        $template = $file->getTemplate();
        $content = $this->twig->render($template, []);

        return LogMessage::success($file->getTarget() . ' success', [
            'path' => $file->getTarget(),
            'trace' => $content,
        ]);
    }
}
