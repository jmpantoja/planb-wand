<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Logger;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Gestor de logs
 *
 * @package PlanB\Wand\Core\Logger
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class LogManager
{

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface $output
     */
    private $output;

    /**
     * Asgina el output
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return \PlanB\Wand\Core\Logger\LogManager
     */
    public function setOutput(OutputInterface $output): self
    {
        $this->output = $output;
        return $this;
    }

    /**
     * Muestra un mensaje tipo info por consola
     *
     * @param string $title
     */
    public function info(string $title): void
    {
        $message = LogMessage::info($title);
        $this->log($message);
    }

    /**
     * Muestra un mensaje tipo success por consola
     *
     * @param string $title
     * @param string[] $verbose
     */
    public function success(string $title, array $verbose = []): void
    {
        $message = LogMessage::success($title, $verbose);
        $this->log($message);
    }

    /**
     * Muestra un mensaje tipo skip por consola
     *
     * @param string $title
     * @param string[] $verbose
     */
    public function skip(string $title, array $verbose = []): void
    {
        $message = LogMessage::skip($title, $verbose);
        $this->log($message);
    }

    /**
     * Muestra un mensaje tipo error por consola
     *
     * @param string $title
     * @param string[] $verbose
     */
    public function error(string $title, array $verbose = []): void
    {
        $message = LogMessage::error($title, $verbose);
        $this->log($message);
    }


    /**
     * Muestra un LogMessage por consola
     *
     * @param \PlanB\Wand\Core\Logger\LogMessage $message
     */
    public function log(LogMessage $message): void
    {
        $isNormal = $this->isNormalVerbosity();


        if ($isNormal) {
            $this->output->writeln($message->parse());
        } else {
            $this->output->writeln($message->parseVerbose());
        }
    }

    /**
     * Indica si estamos en modo verbosity quiet o normal
     *
     * @return bool
     */
    protected function isNormalVerbosity(): bool
    {
        return $this->output->getVerbosity() <= OutputInterface::VERBOSITY_NORMAL;
    }
}
