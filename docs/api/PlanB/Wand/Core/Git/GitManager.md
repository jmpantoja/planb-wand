
                                                                                                                                            
    
# GitManager


> Control del stage de git
>
> 








## Methods

### __construct
``` php
protected __construct (string $projectPath)

GitManager constructor.

```

|Parameters: | | |
| --- | --- | --- |
|string |$projectPath |  |

---


### create
``` php
static[PlanB\Wand\Core\Git\GitManager](../../../../PlanB/Wand/Core/Git/GitManager.md) create (string $base)

Crea una nueva instancia del manager

```

|Parameters: | | |
| --- | --- | --- |
|string |$base |  |

---


### isInitialized
``` php
bool isInitialized ()

Indica si el directorio cwd esta supervisado por git

```


---


### setWhiteList
``` php
[PlanB\Wand\Core\Git\GitManager](../../../../PlanB/Wand/Core/Git/GitManager.md) setWhiteList (array $files)

Asigna una lista de archivos sobre los que si podemos actuar

```

|Parameters: | | |
| --- | --- | --- |
|array |$files |  |

---


### getStagedFiles
``` php
string[] getStagedFiles ()

Devuelve los archivos que estan en el stage

```


---


### hasStagedFiles
``` php
bool hasStagedFiles ()

Indica si hay ficheros en el stage

```


---


### reStageFiles
``` php
bool reStageFiles ()

Vuelve a añadir al stage los archivos modificadoso

```


---


### addFilesToStage
``` php
bool addFilesToStage (array $files)

Añade una serie de archivos al stage

```

|Parameters: | | |
| --- | --- | --- |
|array |$files |  |

---


### run
``` php
protected[Symfony\Component\Process\Process](../../../../Symfony/Component/Process/Process.md) run (string $cmd)

Devuelve un proceso despues de ejecutar un comando git

```

|Parameters: | | |
| --- | --- | --- |
|string |$cmd |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                