
                                                                                                                                            
    
# WandCommand


> Comando wand.
>
> 








## Methods

### __construct
``` php
 __construct ([Symfony\Component\DependencyInjection\ContainerInterface](../../../Symfony/Component/DependencyInjection/ContainerInterface.md) $container = null)

WandCommand constructor.

```

|Parameters: | | |
| --- | --- | --- |
|[Symfony\Component\DependencyInjection\ContainerInterface](../../../Symfony/Component/DependencyInjection/ContainerInterface.md) |$container |  |

---


### setContainer
``` php
 setContainer ([Symfony\Component\DependencyInjection\ContainerInterface](../../../Symfony/Component/DependencyInjection/ContainerInterface.md) $container = null)

{@inheritdoc}

```

|Parameters: | | |
| --- | --- | --- |
|[Symfony\Component\DependencyInjection\ContainerInterface](../../../Symfony/Component/DependencyInjection/ContainerInterface.md) |$container |  |

---


### getContainer
``` php
null|[Symfony\Component\DependencyInjection\ContainerInterface](../../../Symfony/Component/DependencyInjection/ContainerInterface.md) getContainer ()

Devuelve el contenedor.

```


---


### getTaskManager
``` php
[PlanB\Wand\Core\Task\TaskManager](../../../PlanB/Wand/Core/Task/TaskManager.md) getTaskManager ()

Devuelve el gestor de tareas.

```


---


### getTaskRunner
``` php
[PlanB\Wand\Core\Logger\LogManager](../../../PlanB/Wand/Core/Logger/LogManager.md) getTaskRunner ()

Devuelve el gestor de la aplicacion.

```


---


### getPathManager
``` php
[PlanB\Wand\Core\Path\PathManager](../../../PlanB/Wand/Core/Path/PathManager.md) getPathManager ()

Devuelve el gestor de rutas.

```


---


### getContextManager
``` php
[PlanB\Wand\Core\Context\ContextManager](../../../PlanB/Wand/Core/Context/ContextManager.md) getContextManager ()

Devuelve el gestor de contexto.

```


---


### getEventDispatcher
``` php
[Symfony\Component\EventDispatcher\EventDispatcher](../../../Symfony/Component/EventDispatcher/EventDispatcher.md) getEventDispatcher ()

Devuelve el dispatcher.

```


---


### getLogger
``` php
[PlanB\Wand\Core\Logger\LogManager](../../../PlanB/Wand/Core/Logger/LogManager.md) getLogger ()

Devuelve el gestor de logs.

```


---


### configure
``` php
protected configure ()

{@inheritdoc}

```


---


### execute
``` php
protectedint execute ([Symfony\Component\Console\Input\InputInterface](../../../Symfony/Component/Console/Input/InputInterface.md) $input, [Symfony\Component\Console\Output\OutputInterface](../../../Symfony/Component/Console/Output/OutputInterface.md) $output)

{@inheritdoc}

```

|Parameters: | | |
| --- | --- | --- |
|[Symfony\Component\Console\Input\InputInterface](../../../Symfony/Component/Console/Input/InputInterface.md) |$input |  |
|[Symfony\Component\Console\Output\OutputInterface](../../../Symfony/Component/Console/Output/OutputInterface.md) |$output |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                