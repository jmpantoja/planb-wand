
                                                                                                                                            
    
# TaskManager


> Gestiona las tareas.
>
> 








## Methods

### getSubscribedEvents
``` php
staticarray getSubscribedEvents ()

{@inheritdoc}

```


---


### __construct
``` php
 __construct ([PlanB\Wand\Core\Config\ConfigManager](../../../../PlanB/Wand/Core/Config/ConfigManager.md) $configManager, [PlanB\Wand\Core\Context\ContextManager](../../../../PlanB/Wand/Core/Context/ContextManager.md) $contextManager, [PlanB\Wand\Core\Task\TaskBuilder](../../../../PlanB/Wand/Core/Task/TaskBuilder.md) $builder)

TaskManager constructor.

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Config\ConfigManager](../../../../PlanB/Wand/Core/Config/ConfigManager.md) |$configManager |  |
|[PlanB\Wand\Core\Context\ContextManager](../../../../PlanB/Wand/Core/Context/ContextManager.md) |$contextManager |  |
|[PlanB\Wand\Core\Task\TaskBuilder](../../../../PlanB/Wand/Core/Task/TaskBuilder.md) |$builder |  |

---


### setTasks
``` php
[PlanB\Wand\Core\Task\TaskManager](../../../../PlanB/Wand/Core/Task/TaskManager.md) setTasks (array $tasks)

Añade un conjunto de tareas definidas en un array de configuración.

```

|Parameters: | | |
| --- | --- | --- |
|array |$tasks |  |

---


### getTasks
``` php
[PlanB\Wand\Core\Task\TaskInterface](../../../../PlanB/Wand/Core/Task/TaskInterface.md)[] getTasks ()

Devuelve todas las tareas

```


---


### addTask
``` php
[PlanB\Wand\Core\Task\TaskManager](../../../../PlanB/Wand/Core/Task/TaskManager.md) addTask (string $name, [PlanB\Wand\Core\Task\TaskInterface](../../../../PlanB/Wand/Core/Task/TaskInterface.md) $task)

Añade una tarea al stack.

```

|Parameters: | | |
| --- | --- | --- |
|string |$name |  |
|[PlanB\Wand\Core\Task\TaskInterface](../../../../PlanB/Wand/Core/Task/TaskInterface.md) |$task |  |

---


### exists
``` php
bool exists (string $task)

Indica si la tarea está definida.

```

|Parameters: | | |
| --- | --- | --- |
|string |$task |  |

---


### get
``` php
[PlanB\Wand\Core\Task\TaskInterface](../../../../PlanB/Wand/Core/Task/TaskInterface.md) get (string $name)

Devuelve una tarea.

```

|Parameters: | | |
| --- | --- | --- |
|string |$name |  |

---


### executeByName
``` php
int executeByName (string $name)

Ejecuta una tarea definida por su nombre.

```

|Parameters: | | |
| --- | --- | --- |
|string |$name |  |

---


### execute
``` php
int execute ([PlanB\Wand\Core\Task\TaskEvent](../../../../PlanB/Wand/Core/Task/TaskEvent.md) $event)

Ejecuta una tarea

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Task\TaskEvent](../../../../PlanB/Wand/Core/Task/TaskEvent.md) |$event |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                