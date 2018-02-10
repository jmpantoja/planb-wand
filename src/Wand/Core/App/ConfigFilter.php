<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\App;

use PlanB\Wand\Core\App\Exception\UndefinidedActionNameException;
use PlanB\Wand\Core\App\Exception\UndefinidedTaskNameException;

/**
 * Aplica los filtros definidos en custom a la configuración original
 *
 * @package PlanB\Wand\Core\App
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
final class ConfigFilter
{

    /**
     * @var mixed[] $tasks
     */
    private $tasks;

    /**
     * @var mixed[] $custom
     */
    private $custom;

    /**
     * ConfigFilter constructor.
     *
     * @param mixed[] $config
     * @param mixed[] $custom
     */
    private function __construct(array $config, array $custom)
    {
        $this->tasks = $config['tasks'];
        $this->custom = $custom['tasks'];
    }

    /**
     * Crea una nueva instancia
     *
     * @param mixed[] $config
     * @param mixed[] $custom
     *
     * @return \PlanB\Wand\Core\App\ConfigFilter
     */
    public static function create(array $config, array $custom): self
    {
        return new self($config, $custom);
    }

    /**
     * Devuelve la configuración resultante de aplicar los filtros custom
     *
     * @return mixed[]
     */
    public function process(): array
    {
        $this->validateTasksNames();
        $this->validateTasksActionNames();

        $this->filterUndefinidedTasks();

        foreach ($this->tasks as $name => &$task) {
            $task = $this->filterUndefinidedActions($name, $task);
        }

        $this->filterTaskWithNoActions();

        return $this->tasks;
    }

    /**
     * Comprueba que no se hayan usado tareas en custom que no estén definidas en default
     */
    private function validateTasksNames(): void
    {

        $extra = $this->findDiffTaskNames();
        if (!empty($extra)) {
            $availables = array_keys($this->tasks);

            throw UndefinidedTaskNameException::create($extra, $availables);
        }
    }

    /**
     * Busca tareas definidas en custom que no lo estén en default
     *
     * @return string[]
     */
    private function findDiffTaskNames(): array
    {
        $custom = array_keys($this->custom);
        $names = array_keys($this->tasks);

        return array_diff($custom, $names);
    }

    /**
     * Comprueba que no se hayan usado acciones en custom que no estén definidas en default
     */
    private function validateTasksActionNames(): void
    {
        $tasks = array_keys($this->tasks);
        foreach ($tasks as $task) {
            $extra = $this->findDiffActionNames($task);
            if (!empty($extra)) {
                $availables = array_keys($this->tasks[$task]['actions']);
                throw UndefinidedActionNameException::create($task, $extra, $availables);
            }
        }
    }

    /**
     * Busca acciones definidas en custom que no lo estén en default
     *
     * @param string $task
     * @return string[]
     */
    private function findDiffActionNames(string $task): array
    {
        $values = $this->custom[$task] ?? [];
        $custom = array_keys($values);
        $names = array_keys($this->tasks[$task]['actions']);

        return array_diff($custom, $names);
    }

    /**
     * Admite solo las tareas definidas en custom
     *
     */
    private function filterUndefinidedTasks(): void
    {
        $custom = array_keys($this->custom);
        $this->tasks = $this->filterByKey($this->tasks, $custom);
    }


    /**
     * Admite solo las acciones definidas en custom
     *
     * @param string $name
     * @param mixed[] $task
     * @return mixed[]
     */
    private function filterUndefinidedActions(string $name, array $task): array
    {
        $actions = $this->custom[$name];
        $customActions = array_keys($actions);

        $task['actions'] = $this->filterByKey($task['actions'], $customActions);
        return $task;
    }

    /**
     * Descarta las tareas sin acciones
     *
     */
    private function filterTaskWithNoActions(): void
    {
        $this->tasks = array_filter($this->tasks, function ($task) {
            return !empty($task['actions']);
        });
    }

    /**
     * Filtra un array, admitiendo solo las keys de una lista
     *
     * @param mixed[] $input el array
     * @param string[] $valids keys admitidas
     * @return mixed[]
     */
    private function filterByKey(array $input, array $valids): array
    {
        return array_filter($input, function ($key) use ($valids) {
            return in_array($key, $valids);
        }, ARRAY_FILTER_USE_KEY);
    }
}
