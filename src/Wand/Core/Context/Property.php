<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Context;

use PlanB\Wand\Core\Context\Exception\InvalidAnswerException;
use PlanB\Wand\Core\Logger\Question\QuestionMessage;
use Throwable;

/**
 * Clase base para propiedades de composer.json
 *
 * @package PlanB\Wand\Core\Context
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
abstract class Property
{

    /**
     * @var \PlanB\Wand\Core\Logger\Question\QuestionMessage $question
     */
    private $question;

    /**
     * @var string $path
     */
    private $path;

    /**
     * Property private constructor.
     */
    public function __construct()
    {
        $options = [];
        $this->init($options);

        $params = PropertyOptions::create()
            ->resolve($options);

        $this->path = $params['path'];
        $this->build($params['message']);
    }

    /**
     * Inicializa los valores de path y question
     *
     * @param string $message
     */
    private function build(string $message): void
    {
        $this->question = QuestionMessage::create($message)
            ->setOptions($this->getOptions())
            ->setValidator([$this, 'check'])
            ->setNormalizer([$this, 'normalize']);
    }

    /**
     * Define los parámetros path y message
     *
     * @param string[] $options
     */
    abstract public function init(array &$options): void;


    /** Crea una nueva instancia de esta propiedad
     *
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Añade un texto explicando por qué el valor almacenado en composer.json no es correcto
     * @param mixed $value
     */
    public function addWarning($value): void
    {

        try {
            $this->checkInOptions($value);
            $this->checkCustom($value);
        } catch (InvalidAnswerException $exception) {
            $error = $exception->getMessage();
            $this->question->setWarning($error);
        }
    }


    /**
     * Devuelve el objeto Question correctamente configurado
     * @return \PlanB\Wand\Core\Logger\Question\QuestionMessage
     */
    public function getQuestion(): QuestionMessage
    {
        return $this->question;
    }

    /**
     * Devuelve el path de la propiedad
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Comprueba que un valor sea valido para esta propiedad
     *
     * @param mixed $answer
     * @return mixed
     * @throws \PlanB\Wand\Core\Context\Exception\InvalidAnswerException
     */
    public function check($answer)
    {
        $this->checkNotNull($answer);
        $this->checkInOptions($answer);

        $this->checkCustom($answer);

        return $answer;
    }

    /**
     * Comprueba que un valor no sea nulo
     *
     * @param mixed $answer
     */
    private function checkNotNull($answer): void
    {
        if (is_null($answer)) {
            throw  InvalidAnswerException::required();
        }
    }

    /**
     * Comprueba que un valor esté entre los permitidos
     *
     * @param mixed $answer
     */
    private function checkInOptions($answer): void
    {
        $options = $this->getOptions();
        if (empty($options)) {
            return;
        }

        if (!in_array($answer, $options)) {
            throw  InvalidAnswerException::notInOptions($answer, $options);
        }
    }

    /**
     * Validación especifica de la propiedad
     *
     * (solo aplica a instancias de ValidableProperty)
     * @param mixed $answer
     */
    private function checkCustom($answer): void
    {
        if (!($this instanceof ValidableProperty)) {
            return;
        }

        if (!$this->validate($answer)) {
            $message = $this->getErrorMessage($answer);
            throw  InvalidAnswerException::custom($message);
        }
    }


    /**
     * Prepara el valor para ser almacenado en composer.json
     *
     * @param mixed $answer
     * @return mixed
     */
    public function normalize($answer)
    {
        return $answer;
    }

    /**
     * Desnormaliza un valor para esta propiedad
     *
     * @param mixed $answer
     * @return null|string
     */
    public function denormalize($answer): ?string
    {
        return $answer;
    }


    /**
     * Prepara el valor para ser usado como parámetro
     * (Cuando se llama al método toArray de Context)
     *
     * @param mixed $answer
     * @return null|string
     */
    public function resolve($answer): ?string
    {
        return $answer;
    }


    /**
     * Indica si un valor es valido para esta propiedad
     *
     * @param mixed $answer
     * @return bool
     */
    public function isValid($answer): bool
    {
        try {
            $this->check($answer);
            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }

    /**
     * Devuelve un array con los valores admitidos para esta propiedad
     *
     * @return mixed[]
     */
    public function getOptions(): array
    {
        return [];
    }
}
