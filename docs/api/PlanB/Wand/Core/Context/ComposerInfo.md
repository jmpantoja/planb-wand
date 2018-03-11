
                                                                                                                                            
    
# ComposerInfo


> Clase que nos permite leer y escribir valores de composer.json.
>
> 








## Methods

### __construct
``` php
 __construct (string $composerPath)

ComposerInfo constructor.

```

|Parameters: | | |
| --- | --- | --- |
|string |$composerPath |  |

---


### load
``` php
static[PlanB\Wand\Core\Context\ComposerInfo](../../../../PlanB/Wand/Core/Context/ComposerInfo.md) load ([PlanB\Wand\Core\Path\PathManager](../../../../PlanB/Wand/Core/Path/PathManager.md) $pathManager)

Inicializa todos las propiedades de la clase,
segun el contenido del fichero composer.json del proyecto.

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Path\PathManager](../../../../PlanB/Wand/Core/Path/PathManager.md) |$pathManager |  |

---


### get
``` php
mixed get (string $path)

Devuelve el valor que corresponde a un path.

```

|Parameters: | | |
| --- | --- | --- |
|string |$path |  |

---


### set
``` php
[PlanB\Wand\Core\Context\ComposerInfo](../../../../PlanB/Wand/Core/Context/ComposerInfo.md) set (string $path, mixed $value)

Asigna un valor a un path.

```

|Parameters: | | |
| --- | --- | --- |
|string |$path |  |
|mixed |$value |  |

---


### has
``` php
bool has ([PlanB\Wand\Core\Context\Property](../../../../PlanB/Wand/Core/Context/Property.md) $property)

Indica si un path tiene valor.

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Context\Property](../../../../PlanB/Wand/Core/Context/Property.md) |$property |  |

---


### save
``` php
 save ()

Guarda los cambios si los hay.

```


---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                