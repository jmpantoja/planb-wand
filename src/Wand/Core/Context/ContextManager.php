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

use PlanB\Wand\Core\Context\Property\AuthorEmailProperty;
use PlanB\Wand\Core\Context\Property\AuthorHomepageProperty;
use PlanB\Wand\Core\Context\Property\AuthorNameProperty;
use PlanB\Wand\Core\Context\Property\GithubUsernameProperty;
use PlanB\Wand\Core\Context\Property\LicenseProperty;
use PlanB\Wand\Core\Context\Property\PackageDescriptionProperty;
use PlanB\Wand\Core\Context\Property\PackageNameProperty;
use PlanB\Wand\Core\Context\Property\PackageTypeProperty;
use PlanB\Wand\Core\Logger\LogManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Gestiona el contenido de composer.json
 *
 * @package PlanB\Wand\Core\Context
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ContextManager implements EventSubscriberInterface
{
    /**
     * @var \PlanB\Wand\Core\Logger\LogManager $logger
     */
    private $logger;

    /**
     * @var \PlanB\Wand\Core\Context\ComposerInfo $info
     */
    private $info;

    /**
     * @var \PlanB\Wand\Core\Context\Property[] $properties
     */
    private $properties = [];

    /**
     * @var mixed[] $values ;
     */
    private $values;

    /**
     * ContextManager constructor.
     *
     * @param \PlanB\Wand\Core\Logger\LogManager $logger
     * @param \PlanB\Wand\Core\Context\ComposerInfo $info
     */
    public function __construct(LogManager $logger, ComposerInfo $info)
    {
        $this->logger = $logger;
        $this->info = $info;

        $this->properties['package_name'] = PackageNameProperty::create();
        $this->properties['package_description'] = PackageDescriptionProperty::create();
        $this->properties['package_type'] = PackageTypeProperty::create();
        $this->properties['license'] = LicenseProperty::create();
        $this->properties['author_name'] = AuthorNameProperty::create();
        $this->properties['author_email'] = AuthorEmailProperty::create();
        $this->properties['author_homepage'] = AuthorHomepageProperty::create();
        $this->properties['github_username'] = GithubUsernameProperty::create();
    }

    /**
     * @inheritdoc
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            'wand.context.execute' => 'execute',
        ];
    }

    /**
     * Comprueba que el archivo composer.json sea correcto
     *
     * @param \PlanB\Wand\Core\Action\ActionEvent $event
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
     * Devuelve los valores almacenados en composer.json
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        if (empty($this->values)) {
            $this->execute();
        }
        return $this->values;
    }

    /**
     * Devuelve el valor que corresponde a la propiedad pasada
     *
     * @param \PlanB\Wand\Core\Context\Property $property
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
     * Obtiene el valor de la propiedad desde el fichero composer.json
     *
     * @param \PlanB\Wand\Core\Context\Property $property
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
     * Pide por consola el valor de una propiedad
     *
     * @param \PlanB\Wand\Core\Context\Property $property
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
