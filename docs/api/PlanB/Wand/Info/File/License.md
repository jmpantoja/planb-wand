
                                                                                                                                            
    
# License


> Representa al archivo LICENSE.
>
> 




## Constants
- ACTION_CREATE
- ACTION_REMOVE
- ACTION_OVERWRITE


## Properties
- level
- context
- target


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

File constructor.

```

|Parameters: | | |
| --- | --- | --- |
|array |$params |  |

---


### create
``` php
static[PlanB\Wand\Core\File\File](../../../../PlanB/Wand/Core/File/File.md) create (array $options)

Crea una nueva instancia.

```

|Parameters: | | |
| --- | --- | --- |
|array |$options |  |

---


### getProfile
``` php
staticstring getProfile ()

Devuelve el perfil de options para este objeto.

```


---


### getChmod
``` php
int getChmod ()

Devuelve los permisos del fichero.

```


---


### getAction
``` php
string getAction ()

Devuelve la acción (create|delete).

```


---


### getTemplate
``` php
string getTemplate ()

Devuelve la template.

```


---


### getTarget
``` php
string getTarget ()

Devuelve la ruta de destino, (relativa a root_project).

```


---


### getPath
``` php
string getPath ()

Devuelve la ruta absoluta de destino.

```


---


### getVars
``` php
string[] getVars ()

Devuelve las variables necesarias para renderizar el archivo.

```


---


### exists
``` php
bool exists ()

Indica si el fichero ya existe.

```


---


### getGroup
``` php
string getGroup ()

Devuelve el grupo de acciones a la que pertenece este fichero.

```


---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                