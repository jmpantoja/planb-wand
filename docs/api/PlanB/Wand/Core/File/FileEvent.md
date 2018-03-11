
                                                                                                                                            
    
# FileEvent


> Evento que se lanza al tratar un objeto File.
>
> 






## Properties
- message


## Methods

### getName
``` php
string getName ()

Devuelve el nombre del evento.

```


---


### configureLog
``` php
 configureLog ([PlanB\Wand\Core\Logger\Message\LogMessage](../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) $message)

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


### __construct
``` php
 __construct ([PlanB\Wand\Core\File\File](../../../../PlanB/Wand/Core/File/File.md) $file)

FileEvent constructor.

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\File\File](../../../../PlanB/Wand/Core/File/File.md) |$file |  |

---


### getFile
``` php
[PlanB\Wand\Core\File\File](../../../../PlanB/Wand/Core/File/File.md) getFile ()

Devuelve el objeto File.

```


---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                