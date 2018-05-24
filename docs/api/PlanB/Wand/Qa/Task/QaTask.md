
                                                                                                                                            
    
# QaTask


> Quality Assurance
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
Devuelve el nivel de esta acción.


**QaTask::getLevel**() : int



---


### setLevel
Asigna el nivel en la jerarquia de tareas/acciones.


**QaTask::setLevel**(int $level) : [ActionInterface](../../../../ActionInterface.md)


|Parameters: | | |
| --- | --- | --- |
|int |$level |  |

---


### setContext
Asigna el contexto.


**QaTask::setContext**([Context](../../../../Context.md) $context) : [ActionInterface](../../../../ActionInterface.md)


|Parameters: | | |
| --- | --- | --- |
|[Context](../../../../Context.md) |$context |  |

---


### __construct
Task constructor.


final **QaTask::__construct**(array $options) : 


|Parameters: | | |
| --- | --- | --- |
|array |$options |  |

---


### create
Crea una nueva instancia.


final static **QaTask::create**(array $params) : [TaskInterface](../../../../TaskInterface.md)


|Parameters: | | |
| --- | --- | --- |
|array |$params |  |

---


### setName
{@inheritdoc}


**QaTask::setName**(string $name) : [TaskInterface](../../../../TaskInterface.md)


|Parameters: | | |
| --- | --- | --- |
|string |$name |  |

---


### getName
Devuelve el nombre de la tarea.


**QaTask::getName**() : string



---


### setEventDispatcher
Asigna el controlador de eventos.


**QaTask::setEventDispatcher**([EventDispatcher](../../../../EventDispatcher.md) $dispatcher) : [TaskInterface](../../../../TaskInterface.md)


|Parameters: | | |
| --- | --- | --- |
|[EventDispatcher](../../../../EventDispatcher.md) |$dispatcher |  |

---


### setLogger
Asigna el gestor de logs.


**QaTask::setLogger**([LogManager](../../../../LogManager.md) $logger) : [TaskInterface](../../../../TaskInterface.md)


|Parameters: | | |
| --- | --- | --- |
|[LogManager](../../../../LogManager.md) |$logger |  |

---


### getDescription
Devuelve la descripción de la tarea.


**QaTask::getDescription**() : string



---


### getActions
Devuelve las acciones definidas en esta tarea.


**QaTask::getActions**() : [ActionInterface](../../../../ActionInterface.md)[]



---


### exists
Indica si una acción está definida.


**QaTask::exists**(string $name) : bool


|Parameters: | | |
| --- | --- | --- |
|string |$name |  |

---


### get
Devuelve una acción.


**QaTask::get**(string $name) : [ActionInterface](../../../../ActionInterface.md)


|Parameters: | | |
| --- | --- | --- |
|string |$name |  |

---


### file
Devuelve una acción tipo file.


**QaTask::file**(string $name) : [File](../../../../File.md)


|Parameters: | | |
| --- | --- | --- |
|string |$name |  |

---


### run
Ejecuta una acción.


**QaTask::run**(string $action) : [LogMessage](../../../../LogMessage.md)


|Parameters: | | |
| --- | --- | --- |
|string |$action |  |

---


### sequence
Ejecuta varias acciones


**QaTask::sequence**(string ...$actions) : [LogMessage](../../../../LogMessage.md)


|Parameters: | | |
| --- | --- | --- |
|string |...$actions |  |

---


### sequenceFrom
Ejecuta varias acciones


**QaTask::sequenceFrom**([LogMessage](../../../../LogMessage.md) $message, string ...$actions) : [LogMessage](../../../../LogMessage.md)


|Parameters: | | |
| --- | --- | --- |
|[LogMessage](../../../../LogMessage.md) |$message |  |
|string |...$actions |  |

---


### launch
Lanza la tarea.


**QaTask::launch**() : int



---


### execute
{@inheritdoc}


**QaTask::execute**() : 



---


### shouldBeRestaged
Indica si el estado del proceso es el adecuado para hacer un restage


protected **QaTask::shouldBeRestaged**([LogMessage](../../../../LogMessage.md) $message) : bool


|Parameters: | | |
| --- | --- | --- |
|[LogMessage](../../../../LogMessage.md) |$message |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                