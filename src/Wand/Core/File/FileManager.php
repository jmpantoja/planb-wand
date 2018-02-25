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

use PlanB\Wand\Core\Context\ContextManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Gestiona los archivos
 *
 * @package PlanB\Wand\Core\File
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class FileManager implements EventSubscriberInterface
{

    /**
     * @var \Twig_Environment $twig
     */
    private $twig;

    /**
     * @var \PlanB\Wand\Core\Context\ContextManager $context
     */
    private $context;


    public function __construct(\Twig_Environment $twig, ContextManager $context)
    {
        $this->twig = $twig;
        $this->context = $context;
    }

    /**
     * @inheritdoc
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            'wand.file.create' => 'create',
            'wand.file.remove' => 'remove',
        ];
    }

    /**
     * Crea un archivo
     *
     * @param \PlanB\Wand\Core\File\FileEvent $event
     */
    public function create(FileEvent $event): void
    {
        $file = $event->getFile();

        if ($file->exists()) {
            $event->skip();
        } else {
            $this->dumpFile($event);
        }
    }

    /**
     * Escribe el archivo en disco
     *
     * @param \PlanB\Wand\Core\File\FileEvent $event
     */
    private function dumpFile(FileEvent $event): void
    {
        $fileSystem = new Filesystem();
        $file = $event->getFile();

        $template = $file->getTemplate();
        $params = $this->context->toArray();
        $path = $file->getPath();
        $chmod = $file->getChmod();

        try {
            $content = $this->twig->render($template, $params);
            $fileSystem->dumpFile($path, $content);
            $fileSystem->chmod($path, $chmod);

            $event->success();
        } catch (\Throwable $exception) {
            $message = $exception->getMessage();
            $event->error($message);
        }
    }

    /**
     * Elimina un archivo
     *
     * @param \PlanB\Wand\Core\File\FileEvent $event
     */
    public function remove(FileEvent $event): void
    {

        $file = $event->getFile();

        if (!$file->exists()) {
            $event->skip();
        } else {
            $this->deleteFile($event);
        }
    }

    /**
     * Borra un archivo de disco
     */
    private function deleteFile(FileEvent $event): void
    {
        $fileSystem = new Filesystem();
        $file = $event->getFile();
        $path = $file->getPath();

        try {
            $fileSystem->remove($path);
            $event->success();
        } catch (\Throwable $exception) {
            $message = $exception->getMessage();
            $event->error($message);
        }
    }
}
