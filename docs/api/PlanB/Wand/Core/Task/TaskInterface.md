
                                                                                                                                            
    
# TaskInterface


> Modela una tarea.
>
> 








## Methods

### setLevel
``` php
[PlanB\Wand\Core\Action\ActionInterface](../../../../PlanB/Wand/Core/Action/ActionInterface.md) setLevel (int $level)

Asigna el nivel en la jerarquia de tareas/acciones.

```

|Parameters: | | |
| --- | --- | --- |
|int |$level |  |

---


### setContext
``` php
[PlanB\Wand\Core\Action\ActionInterface](../../../../PlanB/Wand/Core/Action/ActionInterface.md) setContext ([PlanB\Wand\Core\Context\Context](../../../../PlanB/Wand/Core/Context/Context.md) $context)

Asigna el contexto.

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Context\Context](../../../../PlanB/Wand/Core/Context/Context.md) |$context |  |

---


### create
``` php
static[PlanB\Wand\Core\Task\TaskInterface](../../../../PlanB/Wand/Core/Task/TaskInterface.md) create (array $params)

Crea una nueva instancia.

```

|Parameters: | | |
| --- | --- | --- |
|array |$params |  |

---


### setEventDispatcher
``` php
[PlanB\Wand\Core\Task\TaskInterface](../../../../PlanB/Wand/Core/Task/TaskInterface.md) setEventDispatcher ([Symfony\Component\EventDispatcher\EventDispatcher](../../../../Symfony/Component/EventDispatcher/EventDispatcher.md) $dispatcher)

Asigna el controlador de eventos.

```

|Parameters: | | |
| --- | --- | --- |
|[Symfony\Component\EventDispatcher\EventDispatcher](../../../../Symfony/Component/EventDispatcher/EventDispatcher.md) |$dispatcher |  |

---


### setLogger
``` php
[PlanB\Wand\Core\Task\TaskInterface](../../../../PlanB/Wand/Core/Task/TaskInterface.md) setLogger ([PlanB\Wand\Core\Logger\LogManager](../../../../PlanB/Wand/Core/Logger/LogManager.md) $logger)

Asigna el gestor de logs.

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Logger\LogManager](../../../../PlanB/Wand/Core/Logger/LogManager.md) |$logger |  |

---


### getLevel
``` php
int getLevel ()

Devuelve el nivel de esta acción.

```


---


### getName
``` php
string getName ()

Devuelve el nombre de la tarea.

```


---


### getDescription
``` php
string getDescription ()

Devuelve la descripción de la tarea.

```


---


### getActions
``` php
[PlanB\Wand\Core\Action\ActionInterface](../../../../PlanB/Wand/Core/Action/ActionInterface.md)[] getActions ()

Devuelve las acciones definidas en esta tarea.

```


---


### launch
``` php
int launch ()

Lanza la tarea.

```


---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                