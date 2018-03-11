
                                                                                                                                            
    
# PhpcsCommand


> Ejecuta phpcs
>
> 






## Properties
- level
- context
- title
- output
- runner


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

Devuelve el comando a ejecutar.

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

Ejecuta el comando

```


---


### getRunner
``` php
[PlanB\Wand\Legacy\Phpcs\CodeSniffer](../../../../PlanB/Wand/Legacy/Phpcs/CodeSniffer.md) getRunner ()

Devuelve el objeto CodeSniffer

```


---


### setRunner
``` php
[PlanB\Wand\Qa\Command\PhpcsCommand](../../../../PlanB/Wand/Qa/Command/PhpcsCommand.md) setRunner ([PlanB\Wand\Legacy\Phpcs\CodeSniffer](../../../../PlanB/Wand/Legacy/Phpcs/CodeSniffer.md) $runner)

Asigna el objeto CodeSniffer

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Legacy\Phpcs\CodeSniffer](../../../../PlanB/Wand/Legacy/Phpcs/CodeSniffer.md) |$runner |  |

---


### initialize
``` php
protected initialize ()

Nos aseguramos de que las clases de codesniffer esten incluidas

```


---


### getTokens
``` php
protectedstring[] getTokens ()

Devuelve los tokens del comando

```


---


### runMethod
``` php
protectedint runMethod (array $tokens)

Ejecuta el método phpcs

```

|Parameters: | | |
| --- | --- | --- |
|array |$tokens |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                