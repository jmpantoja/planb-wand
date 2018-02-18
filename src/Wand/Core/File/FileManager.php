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

use PlanB\Wand\Core\Logger\LogMessage;

/**
 * Gestiona los archivos
 *
 * @package PlanB\Wand\Core\File
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class FileManager
{

    /**
     * Crea / Elimina un archivo
     *
     * @param \PlanB\Wand\Core\File\File $file
     * @return \PlanB\Wand\Core\Logger\LogMessage
     */
    public function execute(File $file): LogMessage
    {


        return LogMessage::success('file success', [
            'path' => 'la ruta',
            'trace' => "asdadsadad\nasadasd\nadsadasda\nadsadasd",
        ]);
    }
}
