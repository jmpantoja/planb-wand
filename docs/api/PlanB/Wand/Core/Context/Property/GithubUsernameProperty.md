
                                                                                                                                            
    
# GithubUsernameProperty


> Propiedad GithubUsername.
>
> 








## Methods

### __construct
``` php
 __construct ()

Property private constructor.

```


---


### init
``` php
 init (array $options)

Define los parámetros path y message.

```

|Parameters: | | |
| --- | --- | --- |
|array |$options |  |

---


### create
``` php
static[PlanB\Wand\Core\Context\Property](../../../../../PlanB/Wand/Core/Context/Property.md) create ()

Crea una nueva instancia de esta propiedad

```


---


### addWarning
``` php
 addWarning (mixed $value)

Añade un texto explicando por qué el valor almacenado en composer.json no es correcto.

```

|Parameters: | | |
| --- | --- | --- |
|mixed |$value |  |

---


### getQuestion
``` php
[PlanB\Wand\Core\Logger\Question\QuestionMessage](../../../../../PlanB/Wand/Core/Logger/Question/QuestionMessage.md) getQuestion ()

Devuelve el objeto Question correctamente configurado.

```


---


### getPath
``` php
string getPath ()

Devuelve el path de la propiedad.

```


---


### check
``` php
mixed check (mixed $answer)

Comprueba que un valor sea valido para esta propiedad.

```

|Parameters: | | |
| --- | --- | --- |
|mixed |$answer |  |

---


### normalize
``` php
mixed normalize (mixed $answer)

Prepara el valor para ser almacenado en composer.json.

```

|Parameters: | | |
| --- | --- | --- |
|mixed |$answer |  |

---


### denormalize
``` php
null|string denormalize (mixed $answer)

Desnormaliza un valor para esta propiedad.

```

|Parameters: | | |
| --- | --- | --- |
|mixed |$answer |  |

---


### resolve
``` php
null|string resolve (mixed $answer)

Prepara el valor para ser usado como parámetro
(Cuando se llama al método toArray de Context).

```

|Parameters: | | |
| --- | --- | --- |
|mixed |$answer |  |

---


### isValid
``` php
bool isValid (mixed $answer)

Indica si un valor es valido para esta propiedad.

```

|Parameters: | | |
| --- | --- | --- |
|mixed |$answer |  |

---


### getOptions
``` php
mixed[] getOptions ()

Devuelve un array con los valores admitidos para esta propiedad.

```


---


### validate
``` php
bool validate (mixed $answer)

Realiza las comprobaciones especificas de esta propiedad.

```

|Parameters: | | |
| --- | --- | --- |
|mixed |$answer |  |

---


### getErrorMessage
``` php
string getErrorMessage (string $answer)

Devuelve el mensaje de error personalizado.

```

|Parameters: | | |
| --- | --- | --- |
|string |$answer |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                