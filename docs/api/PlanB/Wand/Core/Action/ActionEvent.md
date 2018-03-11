
                                                                                                                                            
    
# ActionEvent


> Evento que se lanza al ejecutar una acción.
>
> 






## Properties
- message


## Methods

### getName
``` php
abstractstring getName ()

Devuelve el nombre del evento.

```


---


### configureLog
``` php
abstract configureLog ([PlanB\Wand\Core\Logger\Message\LogMessage](../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) $message)

Configura el mensaje de log.

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) |$message |  |

---


### blank
``` php
[PlanB\Wand\Core\Action\ActionEvent](../../../../PlanB/Wand/Core/Action/ActionEvent.md) blank (int $exitCode)

Termina una acción en modo silencioso.

```

|Parameters: | | |
| --- | --- | --- |
|int |$exitCode |  |

---


### success
``` php
[PlanB\Wand\Core\Action\ActionEvent](../../../../PlanB/Wand/Core/Action/ActionEvent.md) success ()

Crea un mensaje de log tipo success.

```


---


### skip
``` php
[PlanB\Wand\Core\Action\ActionEvent](../../../../PlanB/Wand/Core/Action/ActionEvent.md) skip ()

Crea un mensaje de log tipo skip.

```


---


### error
``` php
[PlanB\Wand\Core\Action\ActionEvent](../../../../PlanB/Wand/Core/Action/ActionEvent.md) error (string $errorMessage = null)

Crea un mensaje de log tipo error.

```

|Parameters: | | |
| --- | --- | --- |
|string |$errorMessage |  |

---


### isNotError
``` php
bool isNotError ()

Indica que el mensaje NO es de tipo error.

```


---


### getMessage
``` php
[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) getMessage ()

Devuelve el mensaje de log.

```


---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                