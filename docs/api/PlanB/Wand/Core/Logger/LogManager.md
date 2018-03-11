
                                                                                                                                            
    
# LogManager


> Gestor de logs.
>
> 








## Methods

### __construct
``` php
 __construct ([Symfony\Component\EventDispatcher\EventDispatcher](../../../../Symfony/Component/EventDispatcher/EventDispatcher.md) $dispatcher)

LogManager constructor.

```

|Parameters: | | |
| --- | --- | --- |
|[Symfony\Component\EventDispatcher\EventDispatcher](../../../../Symfony/Component/EventDispatcher/EventDispatcher.md) |$dispatcher |  |

---


### setLevel
``` php
[PlanB\Wand\Core\Logger\LogManager](../../../../PlanB/Wand/Core/Logger/LogManager.md) setLevel (int $level)

Asigna el nivel actual

```

|Parameters: | | |
| --- | --- | --- |
|int |$level |  |

---


### begin
``` php
 begin ([PlanB\Wand\Core\Task\TaskInterface](../../../../PlanB/Wand/Core/Task/TaskInterface.md) $task)

Muestra por consola el mensaje de incio de una tarea

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Task\TaskInterface](../../../../PlanB/Wand/Core/Task/TaskInterface.md) |$task |  |

---


### info
``` php
 info (string $title)

Muestra un mensaje tipo info por consola.

```

|Parameters: | | |
| --- | --- | --- |
|string |$title |  |

---


### success
``` php
 success (string $title, array $verbose = [])

Muestra un mensaje tipo success por consola.

```

|Parameters: | | |
| --- | --- | --- |
|string |$title |  |
|array |$verbose |  |

---


### skip
``` php
 skip (string $title, array $verbose = [])

Muestra un mensaje tipo skip por consola.

```

|Parameters: | | |
| --- | --- | --- |
|string |$title |  |
|array |$verbose |  |

---


### error
``` php
 error (string $title, array $verbose = [])

Muestra un mensaje tipo error por consola.

```

|Parameters: | | |
| --- | --- | --- |
|string |$title |  |
|array |$verbose |  |

---


### log
``` php
 log ([PlanB\Wand\Core\Action\ActionEvent](../../../../PlanB/Wand/Core/Action/ActionEvent.md) $event)

Muestra un LogMessage por consola.

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Action\ActionEvent](../../../../PlanB/Wand/Core/Action/ActionEvent.md) |$event |  |

---


### message
``` php
 message ([PlanB\Wand\Core\Logger\Message\LogMessage](../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) $message)

Muestra un LogMessage por consola.

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) |$message |  |

---


### question
``` php
string question ([PlanB\Wand\Core\Logger\Question\QuestionMessage](../../../../PlanB/Wand/Core/Logger/Question/QuestionMessage.md) $question)

Pide información al usuario.

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Logger\Question\QuestionMessage](../../../../PlanB/Wand/Core/Logger/Question/QuestionMessage.md) |$question |  |

---


### confirm
``` php
bool confirm (string $message, bool $default = true)

Pide confirmación al usuario.

```

|Parameters: | | |
| --- | --- | --- |
|string |$message |  |
|bool |$default |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                