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

use PlanB\Wand\Core\Path\PathManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Clase que nos permite leer y escribir valores de composer.json.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ComposerInfo
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $propertyAccess;

    /**
     * @var mixed[]
     */
    private $contents;

    /**
     * @var string
     */
    private $composerPath;

    /**
     * @var bool
     */
    private $changed = false;

    /**
     * @var string[]
     */
    private $keyOrder = [];

    /**
     * ComposerInfo constructor.
     */
    public function __construct(string $composerPath)
    {
        $this->initialize($composerPath);
        $this->optimize();

        $this->populateSortedKeys();
    }

    /**
     * Inicializa todos las propiedades de la clase,
     * segun el contenido del fichero composer.json del proyecto.
     *
     * @param \PlanB\Wand\Core\Path\PathManager $pathManager
     *
     * @return \PlanB\Wand\Core\Context\ComposerInfo
     */
    public static function load(PathManager $pathManager): self
    {
        return new self($pathManager->composerJsonPath());
    }

    /**
     * Inicia los atributos del objeto.
     *
     * @param string $composerPath
     */
    private function initialize(string $composerPath): void
    {
        $json = file_get_contents($composerPath);

        $this->composerPath = $composerPath;
        $this->contents = json_decode($json, true);
        $this->propertyAccess = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Define un array con el orden en el que deben aparecer las claves del fichero composer.json.
     */
    private function populateSortedKeys(): void
    {
        $this->keyOrder[] = 'name';
        $this->keyOrder[] = 'description';
        $this->keyOrder[] = 'version';
        $this->keyOrder[] = 'type';
        $this->keyOrder[] = 'keywords';
        $this->keyOrder[] = 'homepage';
        $this->keyOrder[] = 'license';
        $this->keyOrder[] = 'authors';
        $this->keyOrder[] = 'support';
        $this->keyOrder[] = 'require';
        $this->keyOrder[] = 'require-dev';
        $this->keyOrder[] = 'conflict';
        $this->keyOrder[] = 'replace';
        $this->keyOrder[] = 'provide';
        $this->keyOrder[] = 'suggest';
        $this->keyOrder[] = 'autoload';
        $this->keyOrder[] = 'autoload-dev';
        $this->keyOrder[] = 'autoload-dev';
        $this->keyOrder[] = 'minimum-stability';
        $this->keyOrder[] = 'prefer-stable';
        $this->keyOrder[] = 'config';
        $this->keyOrder[] = 'scripts';
        $this->keyOrder[] = 'extra';
        $this->keyOrder[] = 'bin';
        $this->keyOrder[] = 'repositories';
    }

    /**
     * Configura el apartado config para optimizar composer.
     */
    private function optimize(): void
    {
        if (!$this->get('[config][optimize-autoloader]')) {
            $this->set('[config][optimize-autoloader]', true);
        }

        if (!$this->get('[config][sort-packages]')) {
            $this->set('[config][sort-packages]', true);
        }

        if (!$this->get('[config][apcu-autoloader]')) {
            $this->set('[config][apcu-autoloader]', true);
        }

        $this->save();
    }

    /**
     * Devuelve el valor que corresponde a un path.
     *
     * @param string $path
     *
     * @return mixed
     */
    public function get(string $path)
    {
        return $this->propertyAccess->getValue($this->contents, $path);
    }

    /**
     * Asigna un valor a un path.
     *
     * @param string $path
     * @param mixed  $value
     *
     * @return \PlanB\Wand\Core\Context\ComposerInfo
     */
    public function set(string $path, $value): self
    {
        $this->propertyAccess->setValue($this->contents, $path, $value);
        $this->changed = true;

        return $this;
    }

    /**
     * Indica si un path tiene valor.
     *
     * @param \PlanB\Wand\Core\Context\Property $property
     *
     * @return bool
     */
    public function has(Property $property): bool
    {
        $path = $property->getPath();

        return !is_null($this->get($path));
    }

    /**
     * Guarda los cambios si los hay.
     */
    public function save(): void
    {
        if (!$this->changed) {
            return;
        }

        $this->dumpFile();
    }

    /**
     * Escribe los valores en el fichero composer.json.
     */
    private function dumpFile(): void
    {
        $values = $this->getSortedValues();
        $content = json_encode($values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $fileSystem = new Filesystem();

        $fileSystem->dumpFile($this->composerPath, $content);
    }

    /**
     * Ordena los valores por clave, segun el orden defindo en 'keyOrder'.
     *
     * @return mixed[]
     */
    private function getSortedValues(): array
    {
        $keys = array_flip($this->keyOrder);
        $contents = $this->contents;

        uksort($contents, function ($first, $second) use ($keys) {
            $firstWeight = $keys[$first] ?? 100;
            $secondWeight = $keys[$second] ?? 100;

            return $firstWeight - $secondWeight;
        });

        return $contents;
    }
}
