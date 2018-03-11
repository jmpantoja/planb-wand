
                                                                                                                                            
    
# Context


> Contexto de la aplicación.
>
> 








## Methods

### create
``` php
static[PlanB\Wand\Core\Context\Context](../../../../PlanB/Wand/Core/Context/Context.md) create (array $params, array $paths)

Crea una nueva instancia.

```

|Parameters: | | |
| --- | --- | --- |
|array |$params |  |
|array |$paths |  |

---


### getPath
``` php
mixed|string getPath (string $name)

Devuelve una ruta.

```

|Parameters: | | |
| --- | --- | --- |
|string |$name |  |

---


### getPathRelativeTo
``` php
string getPathRelativeTo (string $path, string $base = &#039;project&#039;)

Devuelve una ruta, relativa a una de las rutas del contexto

```

|Parameters: | | |
| --- | --- | --- |
|string |$path |  |
|string |$base |  |

---


### getModifiedFiles
``` php
string[] getModifiedFiles (string $name)

Devuelve los archivos php modificados en una ruta

```

|Parameters: | | |
| --- | --- | --- |
|string |$name |  |

---


### updateLastExecution
``` php
 updateLastExecution ()

Actualiza el timestamp de última ejecución

```


---


### getParams
``` php
string[] getParams ()

Devuelve los valores almacenados en composer.json.

```


---


### getParam
``` php
string getParam (string $name)

Devuelve el valor de un parámetro.

```

|Parameters: | | |
| --- | --- | --- |
|string |$name |  |

---


### getGitManager
``` php
[PlanB\Wand\Core\Git\GitManager](../../../../PlanB/Wand/Core/Git/GitManager.md) getGitManager ()

Devuelve el gestor de Git

```


---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                