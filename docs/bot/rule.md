---
description: >-
  - это возможность провалидировать событие до его обработки по определенным
  правилам.
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

# Правила (Rule)

## Использование правил

Класс, который валидирует событие, должен наследовать от базового класса `BaseRule`. Валидация события происходит в методе `passes`, который принимает объект события, а после возвращает `true` или `false`. Если хоть одно правило вернуло `false` - обработка события текущим хендлером прекращается.

```php
use Fastik1\VkBot\Rules\isChatMessageRule;
use Fastik1\VkBot\Rules\isPrivateMessageRule;
use Fastik1\Vkfast\Bot\Events\MessageNew;

$bot->message(function (MessageNew $event) { // обработка всех сообщений из чатов (использование правила)
    // обработка события, которое прошло валидацию правилами
})->rule(new isChatMessageRule);

$bot->message(function (MessageNew $event) { // обработка всех личных сообщений (использование правила)
    // обработка события, которое прошло валидацию правилами
})->rule([new isPrivateMessageRule, /* другие правила в виде массива */]);
```

## Реализация правила `isChatMessageRule`

```php
namespace Fastik1\Vkfast\Bot\Rules; // используйте свой namespace при создании собственных правил

use Fastik1\Vkfast\Bot\Events\Event;
use Fastik1\Vkfast\Bot\Events\MessageNew;

class IsChatMessageBaseRule extends BaseRule
{
    public function passes(MessageNew|Event $event): bool
    {
        return $event->message->peer_id != $event->message->from_id; // если peer_id и from_id равны - значит это сообщение из чата
    }
}
```

{% hint style="info" %}
isChatMessageRule и isPrivateMessageRule - базовые правила, проверяющие сообщение на источник: чат или личное сообщение.
{% endhint %}

## Использование динамический правил

Вы можете сделать свое правило динамичным. Пример такого правила:

```php
use Fastik1\Vkfast\Bot\Events\Event;
use Fastik1\Vkfast\Bot\Events\MessageEvent;
use Fastik1\Vkfast\Bot\Rules\BaseRule;

class PeerIdRule extends BaseRule
{
    private int $peer_id;

    public function __construct(int $peer_id)
    {
        $this->peer_id= $peer_id;
    }

    public function passes(MessageEvent|Event $event): bool
    {
        return $event->message->peer_id == $this->peer_id;
    }
}
```

Использование такого правила:

```php
$bot->message(function (MessageNew $event) { // обработка всех сообщений из чатов (использование правила) 
    // обработка события, которое прошло валидацию правилами
})->rule(new PeerIdRule(2000000001));
```

Таким образом, мы можем удобно проверять событие на определенный `peer_id`.
