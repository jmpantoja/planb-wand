
                                                                                                                                            
    
# LogMessage


> Representa un mensaje mostrado por consola.
>
> 




## Constants
- TAB




## Methods

### setLevel
``` php
[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) setLevel (int $level)

Asigna el nivel en la jerarquia de logs.

```

|Parameters: | | |
| --- | --- | --- |
|int |$level |  |

---


### setTitle
``` php
[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) setTitle (string $title)

Asigna el titulo.

```

|Parameters: | | |
| --- | --- | --- |
|string |$title |  |

---


### setVerbose
``` php
[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) setVerbose (array $verbose)

Asigna las lineas de verbose.

```

|Parameters: | | |
| --- | --- | --- |
|array |$verbose |  |

---


### addVerbose
``` php
[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) addVerbose (string $title, string $body)

Añade una linea al verbose.

```

|Parameters: | | |
| --- | --- | --- |
|string |$title |  |
|string |$body |  |

---


### info
``` php
static[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) info ()

Crea una nueva instancia de mensaje tipo &quot;info&quot;.

```


---


### success
``` php
static[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) success ()

Crea una nueva instancia de mensaje tipo  &quot;success&quot;.

```


---


### skip
``` php
static[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) skip ()

Crea una nueva instancia de mensaje tipo  &quot;skip&quot;.

```


---


### error
``` php
static[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) error ()

Crea una nueva instancia de mensaje tipo  &quot;error&quot;.

```


---


### getType
``` php
[PlanB\Wand\Core\Logger\Message\MessageType](../../../../../PlanB/Wand/Core/Logger/Message/MessageType.md) getType ()

Devuelve el tipo de mensaje.

```


---


### isInfo
``` php
bool isInfo ()

Indica si el mensaje es de tipo info.

```


---


### isSuccessful
``` php
bool isSuccessful ()

Indica si el mensaje es de tipo success.

```


---


### isSkipped
``` php
bool isSkipped ()

Indica si el mensaje es de tipo skip.

```


---


### isError
``` php
bool isError ()

Indica si el mensaje es de tipo error.

```


---


### parse
``` php
string[] parse ()

Devuelve el mensage en forma de lineas de texto.

```


---


### parseVerbose
``` php
string[] parseVerbose ()

Devuelve el mensage en forma de lineas de texto.

```


---


### getExitCode
``` php
int getExitCode ()

Devuelve el código de error

```


---


### mergeType
``` php
[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) mergeType ([PlanB\Wand\Core\Logger\Message\LogMessage](../../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) $message)

Combina el tipo de dos mensajes, considerando la jerarquia:
1. error
2. skip
3. success

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Logger\Message\LogMessage](../../../../../PlanB/Wand/Core/Logger/Message/LogMessage.md) |$message |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                