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
use PlanB\Wand\Core\Logger\LogManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Gestiona los archivos
 *
 * @package PlanB\Wand\Core\File
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class FileManager implements EventSubscriberInterface
{


    /**
     * @var \PlanB\Wand\Core\Logger\LogManager $logger
     */
    private $logger;

    /**
     * @var \Twig_Environment $twig
     */
    private $twig;


    public function __construct(LogManager $logger, \Twig_Environment $twig)
    {
        $this->logger = $logger;
        $this->twig = $twig;
    }

    /**
     * @inheritdoc
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            'wand.file.execute' => 'execute',
        ];
    }

    /**
     * Crea / Elimina un archivo
     *
     * @param \PlanB\Wand\Core\Action\ActionEvent $event
     */
    public function execute(ActionEvent $event): void
    {

        $file = $event->getFile();

        $template = $file->getTemplate();
        $content = $this->twig->render($template, []);

        $event->error($file->getTarget() . ' success', [
            'path' => $file->getTarget(),
            'trace' => $content,
        ]);

        $this->logger->log($event);
    }
}
