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

use PlanB\Utils\Path\Path;

/**
 * Representa a un directorio del proyecto.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class Directory extends File
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public static function getProfile(): string
    {
        return 'without-template';
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        $projectDir = $this->context->getPath('project');

        return Path::join($projectDir, $this->target, '.gitkeep');
    }
}
