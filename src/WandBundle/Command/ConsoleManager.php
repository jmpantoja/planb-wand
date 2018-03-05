<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\WandBundle\Command;

use PlanB\Wand\Core\Logger\Confirm\ConfirmEvent;
use PlanB\Wand\Core\Logger\Message\MessageEvent;
use PlanB\Wand\Core\Logger\Question\QuestionEvent;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Gestiona los eventos relacionado con mostrar o pedir información por consola.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ConsoleManager implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\Console\Helper\HelperSet
     */
    private $helperSet;

    /**
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    private $input;

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    private $output;

    /**
     * ConsoleManager constructor.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    private function __construct(InputInterface $input, OutputInterface $output, HelperSet $helperSet)
    {
        $this->input = $input;
        $this->output = $output;
        $this->helperSet = $helperSet;
    }

    /**
     * Crea una nueva instancia.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return \PlanB\WandBundle\Command\ConsoleManager
     */
    public static function create(InputInterface $input, OutputInterface $output, HelperSet $helperSet): self
    {
        return new self($input, $output, $helperSet);
    }

    /**
     * {@inheritdoc}
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            'wand.log.message' => 'message',
            'wand.log.question' => 'question',
            'wand.log.confirm' => 'confirm',
        ];
    }

    /**
     * Devuelve el question Helper.
     *
     * @return \Symfony\Component\Console\Helper\QuestionHelper
     */
    public function getQuestionHelper(): QuestionHelper
    {
        return $this->helperSet->get('question');
    }

    /**
     * Muestra un mensaje por consola.
     *
     * @param \PlanB\Wand\Core\Logger\Message\MessageEvent $event
     */
    public function message(MessageEvent $event): void
    {
        $message = $event->getMessage();
        $isNormal = $this->isNormalVerbosity();

        if ($isNormal) {
            $this->output->writeln($message->parse());
        } else {
            $this->output->writeln($message->parseVerbose());
        }
    }

    /**
     * Indica si estamos en modo verbosity quiet o normal.
     *
     * @return bool
     */
    private function isNormalVerbosity(): bool
    {
        return $this->output->getVerbosity() <= OutputInterface::VERBOSITY_NORMAL;
    }

    /**
     * Pide información al usuario.
     *
     * @param \PlanB\Wand\Core\Logger\Question\QuestionEvent $event
     */
    public function question(QuestionEvent $event): void
    {
        $question = $this->eventToQuestion($event);
        $helper = $this->getQuestionHelper();

        $answer = $helper->ask($this->input, $this->output, $question);

        $event->setAnswer($answer);
    }

    /**
     * Convierte un objeto QuestionEvent en un Question, adecuado para la consola.
     *
     * @param \PlanB\Wand\Core\Logger\Question\QuestionEvent $event
     *
     * @return \Symfony\Component\Console\Question\Question
     */
    private function eventToQuestion(QuestionEvent $event): Question
    {
        $message = $event->getQuestion();
        $text = $message->getMessage();
        $default = $message->getDefault();

        if ($message->hasOptions()) {
            $options = $message->getOptions();
            $question = new ChoiceQuestion($text, $options, $default);
        } else {
            $question = new Question($text, $default);
        }

        $question->setNormalizer($message->getNormalizer());
        $question->setValidator($message->getValidator());

        return $question;
    }

    /**
     * Pide información al usuario.
     *
     * @param \PlanB\Wand\Core\Logger\Confirm\ConfirmEvent $event
     */
    public function confirm(ConfirmEvent $event): void
    {
        $message = $event->getConfirm();
        $text = $message->getMessage();
        $default = $message->isTrueByDefault();

        $question = new ConfirmationQuestion($text, $default);

        $helper = $this->getQuestionHelper();

        $answer = $helper->ask($this->input, $this->output, $question);
        $event->setAnswer($answer);
    }
}
