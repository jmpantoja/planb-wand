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

use PlanB\Wand\Core\Context\Property\PropertyCollection;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Path\PathManager;

/**
 * Gestiona el contenido de composer.json.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ContextManager
{
    /**
     * @var \PlanB\Wand\Core\Logger\LogManager
     */
    private $logger;

    /**
     * @var \PlanB\Wand\Core\Path\PathManager
     */
    private $pathManager;

    /**
     * @var \PlanB\Wand\Core\Context\ComposerInfo
     */
    private $info;

    /**
     * @var \PlanB\Wand\Core\Context\Property[]
     */
    private $properties = [];

    /**
     * @var mixed[] ;
     */
    private $values = [];

    /**
     * @var \PlanB\Wand\Core\Context\Context
     */
    private $context;

    /**
     * ContextManager constructor.
     *
     * @param \PlanB\Wand\Core\Logger\LogManager $logger
     * @param \PlanB\Wand\Core\Path\PathManager  $pathManager
     */
    public function __construct(LogManager $logger, PathManager $pathManager)
    {
        $this->logger = $logger;
        $this->pathManager = $pathManager;
        $this->info = ComposerInfo::load($pathManager);

        $this->properties = PropertyCollection::getAll();
    }

    /**
     * Comprueba que el archivo composer.json sea correcto.
     */
    public function execute(): void
    {
        $this->logger->info('Checking composer.json info...');
        foreach ($this->properties as $key => $property) {
            $this->values[$key] = $this->resolve($property);
        }

        $this->info->save();
    }

    /**
     * Devuelve el contexto de la aplicación.
     *
     * @return \PlanB\Wand\Core\Context\Context
     */
    public function getContext(): Context
    {
        if (empty($this->context)) {
            $params = $this->getValues();
            $paths = $this->pathManager->getPaths();
            $this->context = Context::create($params, $paths);
        }

        return $this->context;
    }

    /**
     * Devuelve los valores almacenados en composer.json.
     *
     * @return mixed[]
     */
    private function getValues(): array
    {
        if (empty($this->values)) {
            $this->execute();
        }

        return $this->values;
    }

    /**
     * Devuelve el valor que corresponde a la propiedad pasada.
     *
     * @param \PlanB\Wand\Core\Context\Property $property
     *
     * @return null|string
     */
    private function resolve(Property $property): ?string
    {
        if ($this->info->has($property)) {
            $value = $this->read($property);
        } else {
            $value = $this->ask($property);
        }

        return $property->resolve($value);
    }

    /**
     * Obtiene el valor de la propiedad desde el fichero composer.json.
     *
     * @param \PlanB\Wand\Core\Context\Property $property
     *
     * @return string
     */
    private function read(Property $property): string
    {
        $path = $property->getPath();
        $value = $this->info->get($path);

        if (!$property->isValid($value)) {
            $property->addWarning($value);
            $value = $this->ask($property);
        }

        return $value;
    }

    /**
     * Pide por consola el valor de una propiedad.
     *
     * @param \PlanB\Wand\Core\Context\Property $property
     *
     * @return string
     */
    private function ask(Property $property): string
    {
        $path = $property->getPath();
        $question = $property->getQuestion();

        $value = $this->logger->question($question);

        $this->info->set($path, $value);

        return $value;
    }
}
