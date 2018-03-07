<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Context\Property;

use PlanB\Wand\Core\Context\Property;
use PlanB\Wand\Core\Context\ValidableProperty;

/**
 * Propiedad author email.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class AuthorEmailProperty extends Property implements ValidableProperty
{
    /**
     * Define los parámetros path y message.
     *
     * @param string[] $options
     */
    public function init(array &$options): void
    {
        $options['path'] = '[authors][0][email]';
        $options['message'] = 'Author Email';
    }

    /**
     * Realiza las comprobaciones especificas de esta propiedad.
     *
     * @param mixed $answer
     * @return bool
     */
    public function validate($answer): bool
    {
        return filter_var($answer, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Devuelve el mensaje de error personalizado.
     *
     * @return string
     */
    public function getErrorMessage(string $answer): string
    {
        return sprintf('El formato de "%s" no es correcto, se esperaba un email', $answer);
    }
}
