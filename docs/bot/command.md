---
description: >-
  - это часто используемый метод взаимодействия бота с пользователем. В
  библиотеке реализована возможность очень удобно обрабатывать входящие команды.
layout:
  title:
    visible: true
  description:
    visible: true
  tableOfContents:
    visible: true
  outline:
    visible: true
  pagination:
    visible: false
---

# Команды

Важной особенностью является тот факт, что можно задать любой путь к тексту от пользователя, будь то обычное сообщение, либо вовсе комментарий. Например, путь к тексту обычного сообщения (событие `message_new`) будет `object.message.text` (значение по умолчанию).

```php
use Fastik1\VkBot\Commands\ExampleCommand;

$bot->setPrefix('/'); // установка префикса команды, по умолчанию: '!'

$bot->message(function ($event, $command, $argument1, $argument2) { // обработка команды /hello с двумя аргументами, которые приходят в функцию.
    // do something
})->command('hello');

$bot->message(function ($event, $command, $argument1, $argument2) { // обработка команды /hello с двумя аргументами в событии 'message_new'.
    // do something
})->command('hello', 'object.message.text', new ExampleBaseCommand);

$bot->message(function ($event, $command, $argument1, $argument2) { //  обработка команды /hello с двумя аргументами в событии 'wall_post_new' (как видим, в событии 'wall_post_new' необходимый для обработки текст находится в другом месте, поэтому мы указываем путь к нему)
    // do something
})->command('hello', 'object.text', new ExampleBaseCommand)
```

## Класс для команды

Что такое класс команды? Это класс, который будет пре-валидировать команду (да-да, что-то схожнее с Rule, но другое).

Указание класса команды не обязательно.&#x20;

Реализация класса для команды представлена ниже. Вместо события MessageNew может быть любое другое - это необходимо для типизации в IDE.

```php
namespace Fastik1\Vkfast\Bot\Commands; // используйте свой namespace при создании собственных правил

class ExampleBaseCommand extends BaseCommand
{
    public function validate(MessageNew|Event $event, string $command, array $arguments): bool|array
    {
        return ['command' => $command, 'arguments' => $arguments];
    }
}
```

Класс команды должен возвращать либо массив с ключами "command" и "arguments", при необходимости изменяя их, либо false - для того, чтобы прекратить обработку команды и не попасть в обработчик.

{% hint style="info" %}
Например, вы можете изменить какие-то аргументы команды (они приходят как массив), которые после попадут в обработчик
{% endhint %}
