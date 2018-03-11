
                                                                                                                                            
    
# PathManager


> Gestiona las rutas utiles para la aplicacion.
>
> 








## Methods

### __construct
``` php
 __construct ()

PathManager constructor.

```


---


### build
``` php
 build (string $projectDir)

Configura todas las rutas desde la ruta del proyecto
Si la ruta no contiene un archivo composer.json, lo busca en los padres
Si no lo encuentra, o no existe lanza una excepción.

```

|Parameters: | | |
| --- | --- | --- |
|string |$projectDir |  |

---


### findProjectDir
``` php
protectedstring findProjectDir (string $projectDir)

Localiza el directorio del proyecto
Busca un fichero composer.json en el projectDir o en sus padres, hasta encontralo.

```

|Parameters: | | |
| --- | --- | --- |
|string |$projectDir |  |

---


### projectDir
``` php
string projectDir ()

Devuelve la ruta del proyecto.

```


---


### targetPath
``` php
string targetPath ()

Devuelve la ruta indicada como argumento.

```


---


### composerJsonPath
``` php
string composerJsonPath ()

Devuelve la ruta del archivo composer.json.

```


---


### wandDir
``` php
string wandDir ()

Devuelve la ruta del proyecto wand.

```


---


### getPaths
``` php
string[] getPaths ()

Devuelve un array con todas las rutas.

```


---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                