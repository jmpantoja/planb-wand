<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\ProjectInfo\File;

use PlanB\Wand\Core\File\File;
use PlanB\Wand\Core\File\FileOptions;

/**
 * Representa al archivo LICENSE
 *
 * @package PlanB\Wand\MetaInfo\File
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class License extends File
{
    /**
     * Crea una nueva instancia
     *
     * @param mixed[] $options
     * @return \PlanB\Wand\Core\File\File
     *
     */
    public static function create(array $options): File
    {
        $params = $options['params'] ?? [];
        $params['group'] = $options['group'];

        $params = FileOptions::create('without-template')
            ->resolve($params);

        return new self($params);
    }

    /**
     * @inheritDoc
     */
    public function getTemplate(): string
    {
        $license = $this->context->getParam('license');
        return sprintf('@wand.projectInfo/license/%s.twig', strtolower($license));
    }
}
