
                                                                                                                                            
    
# SystemCommand


> Comandos del sistema
>
> 






## Properties
- level
- context
- title
- output


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
protected __construct (array $params)

Command constructor.

```

|Parameters: | | |
| --- | --- | --- |
|array |$params |  |

---


### create
``` php
static[PlanB\Wand\Core\Command\Command](../../../../PlanB/Wand/Core/Command/Command.md) create (array $options)

Crea una nueva instancia.

```

|Parameters: | | |
| --- | --- | --- |
|array |$options |  |

---


### getCommandLine
``` php
string getCommandLine ()



```


---


### parseModifiedFiles
``` php
string parseModifiedFiles (array $files)

Formatea el argumento ruta

```

|Parameters: | | |
| --- | --- | --- |
|array |$files |  |

---


### getCommandTokens
``` php
string[] getCommandTokens ()

Devuelve la linea de comandos, separada en tokens

```


---


### getDefaultTitle
``` php
string getDefaultTitle ()

Devuelve el titulo del mensaje de log

```


---


### getTitle
``` php
string getTitle ()

Devuelve el titulo del mensaje de log

```


---


### getOutput
``` php
string getOutput ()

Devuelve la salida.

```


---


### getGroup
``` php
string getGroup ()

Devuelve el grupo de acciones a la que pertenece este comando.

```


---


### execute
``` php
[PlanB\Wand\Core\Logger\Message\MessageType](../../../../PlanB/Wand/Core/Logger/Message/MessageType.md) execute ()

Ejecuta el comando

```


---


### run
``` php
bool run ()



```


---


### getCwd
``` php
null|string getCwd ()

Devuelve el directorio de trabajo.

```


---


### isSuccessful
``` php
protectedbool isSuccessful ([Symfony\Component\Process\Process](../../../../Symfony/Component/Process/Process.md) $process)

Indica si el comando se ha ejecutado con exito.

```

|Parameters: | | |
| --- | --- | --- |
|[Symfony\Component\Process\Process](../../../../Symfony/Component/Process/Process.md) |$process |  |

---


### buildOutput
``` php
protected buildOutput ([Symfony\Component\Process\Process](../../../../Symfony/Component/Process/Process.md) $process)

Calcula la salida del comando.

```

|Parameters: | | |
| --- | --- | --- |
|[Symfony\Component\Process\Process](../../../../Symfony/Component/Process/Process.md) |$process |  |

---


### getSuccessOutput
``` php
protectedstring getSuccessOutput ([Symfony\Component\Process\Process](../../../../Symfony/Component/Process/Process.md) $process)

Devuelve la salida del comando en caso de exito.

```

|Parameters: | | |
| --- | --- | --- |
|[Symfony\Component\Process\Process](../../../../Symfony/Component/Process/Process.md) |$process |  |

---


### getErrorOutput
``` php
protectedstring getErrorOutput ([Symfony\Component\Process\Process](../../../../Symfony/Component/Process/Process.md) $process)

Devuelve la salida del comando en caso de error.

```

|Parameters: | | |
| --- | --- | --- |
|[Symfony\Component\Process\Process](../../../../Symfony/Component/Process/Process.md) |$process |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                