
                                                                                                                                            
    
# SamiTask


> Actualiza la documentación
>
> 




## Constants
- EXIT_SUCCESS
- EXIT_FAIL


## Properties
- level
- context
- dispatcher
- logger


## Methods

### getLevel
``` php
int getLevel ()

Devuelve el nivel de esta acción.

```


---


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


### __construct
``` php
final __construct (array $options)

Task constructor.

```

|Parameters: | | |
| --- | --- | --- |
|array |$options |  |

---


### create
``` php
finalstatic[PlanB\Wand\Core\Task\TaskInterface](../../../../PlanB/Wand/Core/Task/TaskInterface.md) create (array $params)

Crea una nueva instancia.

```

|Parameters: | | |
| --- | --- | --- |
|array |$params |  |

---


### setName
``` php
[PlanB\Wand\Core\Task\TaskInterface](../../../../PlanB/Wand/Core/Task/TaskInterface.md) setName (string $name)

{@inheritdoc}

```

|Parameters: | | |
| --- | --- | --- |
|string |$name |  |

---


### getName
``` php
string getName ()

Devuelve el nombre de la tarea.

```


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


### exists
``` php
bool exists (string $name)

Indica si una acción está definida.

```

|Parameters: | | |
| --- | --- | --- |
|string |$name |  |

---


### get
``` php
[PlanB\Wand\Core\Action\ActionInterface](../../../../PlanB/Wand/Core/Action/ActionInterface.md) get (string $name)

Devuelve una acción.

```

|Parameters: | | |
| --- | --- | --- |
|string |$name |  |

---


### file
``` php
[PlanB\Wand\Core\File\File](../../../../PlanB/Wand/Core/File/File.md) file (string $name)

Devuelve una acción tipo file.

```

|Parameters: | | |
| --- | --- | --- |
|string |$name |  |

---


### run
``` php
[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) run (string $action)

Ejecuta una acción.

```

|Parameters: | | |
| --- | --- | --- |
|string |$action |  |

---


### sequence
``` php
[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) sequence (string ...$actions)

Ejecuta varias acciones

```

|Parameters: | | |
| --- | --- | --- |
|string |...$actions |  |

---


### sequenceFrom
``` php
[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) sequenceFrom ([PlanB\Wand\Core\Logger\Message\LogMessage](../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) $message, string ...$actions)

Ejecuta varias acciones

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) |$message |  |
|string |...$actions |  |

---


### launch
``` php
int launch ()

Lanza la tarea.

```


---


### execute
``` php
 execute ()

{@inheritdoc}

```


---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                