<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Git\File;

use PlanB\Wand\Core\File\File;

/**
 * Archivo .gitignore
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class GitIgnoreFile extends File
{
    /**
     * @inheritDoc
     *
     * @return bool
     */
    public function exists(): bool
    {
        $exists = parent::exists();

        if ($exists) {
            $path = $this->getPath();
            $contents = file_get_contents($path);

            $exists = (1 === preg_match('/\.wand\-cache/m', $contents));
        }

        return $exists;
    }
}
