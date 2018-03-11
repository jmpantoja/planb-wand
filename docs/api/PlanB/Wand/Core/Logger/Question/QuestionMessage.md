
                                                                                                                                            
    
# QuestionMessage


> Representa una pregunta que queremos hacer al usuario
Vale para solicitar información o para pedir confirmación.
>
> 








## Methods

### create
``` php
static[PlanB\Wand\Core\Logger\Question\QuestionMessage](../../../../../PlanB/Wand/Core/Logger/Question/QuestionMessage.md) create (string $message)

Crea una nueva instancia.

```

|Parameters: | | |
| --- | --- | --- |
|string |$message |  |

---


### getMessage
``` php
string getMessage ()

Devuelve el mensaje.

```


---


### setWarning
``` php
[PlanB\Wand\Core\Logger\Question\QuestionMessage](../../../../../PlanB/Wand/Core/Logger/Question/QuestionMessage.md) setWarning (string $warning)

Asigna el texto de advertencia.

```

|Parameters: | | |
| --- | --- | --- |
|string |$warning |  |

---


### getDefault
``` php
null|string getDefault ()

Devuelve el valor por defecto.

```


---


### setDefault
``` php
[PlanB\Wand\Core\Logger\Question\QuestionMessage](../../../../../PlanB/Wand/Core/Logger/Question/QuestionMessage.md) setDefault (string $default)

Asigna el valor por defecto.

```

|Parameters: | | |
| --- | --- | --- |
|string |$default |  |

---


### hasOptions
``` php
bool hasOptions ()

Indica si hay opciones.

```


---


### getOptions
``` php
string[] getOptions ()

Devuelve las opciones válidas para esta question.

```


---


### setOptions
``` php
[PlanB\Wand\Core\Logger\Question\QuestionMessage](../../../../../PlanB/Wand/Core/Logger/Question/QuestionMessage.md) setOptions (array $options)

Asigna las opciones para esta question.

```

|Parameters: | | |
| --- | --- | --- |
|array |$options |  |

---


### getValidator
``` php
callable getValidator ()

Devuelve el validador.

```


---


### setValidator
``` php
[PlanB\Wand\Core\Logger\Question\QuestionMessage](../../../../../PlanB/Wand/Core/Logger/Question/QuestionMessage.md) setValidator (callable $validator)

Asigna el validador.

```

|Parameters: | | |
| --- | --- | --- |
|callable |$validator |  |

---


### getNormalizer
``` php
callable getNormalizer ()

Devuelve el normalizador.

```


---


### setNormalizer
``` php
[PlanB\Wand\Core\Logger\Question\QuestionMessage](../../../../../PlanB/Wand/Core/Logger/Question/QuestionMessage.md) setNormalizer (callable $normalizer)

Asigna el normalizador.

```

|Parameters: | | |
| --- | --- | --- |
|callable |$normalizer |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                