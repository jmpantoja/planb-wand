
                                                                                                                                            
    
# BaseConfig


> Base para las clases Configuración
Contiene lógica y métodos comunes a DefaultConfig y CustomConfig.
>
> 








## Methods

### create
``` php
static[PlanB\Wand\Core\Config\BaseConfig](../../../../PlanB/Wand/Core/Config/BaseConfig.md) create (string ...$path)

Crea una nueva instancia.

```

|Parameters: | | |
| --- | --- | --- |
|string |...$path |  |

---


### getConfigTree
``` php
abstractprotected[Symfony\Component\Config\Definition\Builder\TreeBuilder](../../../../Symfony/Component/Config/Definition/Builder/TreeBuilder.md) getConfigTree ()

Generates the configuration tree builder.

```


---


### readFromFile
``` php
protectedmixed[] readFromFile (string $path)

Read the config/wand.yml file.

```

|Parameters: | | |
| --- | --- | --- |
|string |$path |  |

---


### process
``` php
mixed[] process ()

Devuelve la configuración validada y normalizada.

```


---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                