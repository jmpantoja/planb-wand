
                                                                                                                                            
    
# ConsoleManager


> Gestiona los eventos relacionado con mostrar o pedir información por consola.
>
> 








## Methods

### create
``` php
static[PlanB\WandBundle\Command\ConsoleManager](../../../PlanB/WandBundle/Command/ConsoleManager.md) create ([Symfony\Component\Console\Input\InputInterface](../../../Symfony/Component/Console/Input/InputInterface.md) $input, [Symfony\Component\Console\Output\OutputInterface](../../../Symfony/Component/Console/Output/OutputInterface.md) $output, [Symfony\Component\Console\Helper\HelperSet](../../../Symfony/Component/Console/Helper/HelperSet.md) $helperSet)

Crea una nueva instancia.

```

|Parameters: | | |
| --- | --- | --- |
|[Symfony\Component\Console\Input\InputInterface](../../../Symfony/Component/Console/Input/InputInterface.md) |$input |  |
|[Symfony\Component\Console\Output\OutputInterface](../../../Symfony/Component/Console/Output/OutputInterface.md) |$output |  |
|[Symfony\Component\Console\Helper\HelperSet](../../../Symfony/Component/Console/Helper/HelperSet.md) |$helperSet |  |

---


### getSubscribedEvents
``` php
staticarray getSubscribedEvents ()

{@inheritdoc}

```


---


### getQuestionHelper
``` php
[Symfony\Component\Console\Helper\QuestionHelper](../../../Symfony/Component/Console/Helper/QuestionHelper.md) getQuestionHelper ()

Devuelve el question Helper.

```


---


### message
``` php
 message ([PlanB\Wand\Core\Logger\Message\MessageEvent](../../../PlanB/Wand/Core/Logger/Message/MessageEvent.md) $event)

Muestra un mensaje por consola.

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Logger\Message\MessageEvent](../../../PlanB/Wand/Core/Logger/Message/MessageEvent.md) |$event |  |

---


### question
``` php
 question ([PlanB\Wand\Core\Logger\Question\QuestionEvent](../../../PlanB/Wand/Core/Logger/Question/QuestionEvent.md) $event)

Pide información al usuario.

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Logger\Question\QuestionEvent](../../../PlanB/Wand/Core/Logger/Question/QuestionEvent.md) |$event |  |

---


### confirm
``` php
 confirm ([PlanB\Wand\Core\Logger\Confirm\ConfirmEvent](../../../PlanB/Wand/Core/Logger/Confirm/ConfirmEvent.md) $event)

Pide información al usuario.

```

|Parameters: | | |
| --- | --- | --- |
|[PlanB\Wand\Core\Logger\Confirm\ConfirmEvent](../../../PlanB/Wand/Core/Logger/Confirm/ConfirmEvent.md) |$event |  |

---


                                                                                                                                                                                                                                                                                                                                                                                                            
    
                                                                                                                                                                                                                                                                             
                