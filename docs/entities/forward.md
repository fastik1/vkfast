---
description: Методы этой сущности упрощают создание пересылаемого сообщения
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

# Forward

## Инициализация

{% code title="Конструктор" %}
```php
public function __construct(
    int $peer_id,
    bool $is_reply = false,
    ?int $owner_id = null
)

$forward = new Forward(2000000001);
```
{% endcode %}

## Методы

### `addConversationMessageId`

Метод добавляет один или несколько (в таком случае передавайте массив) `conversation_message_id` к объекту пересылаемого сообщения.

```php
$forward->addConversationMessageId(200) // добавить 200-ый conversation_message_id 
$forward->addConversationMessageId([201, 230, 500]) // добавить 201 230 500 conversation_message_id 
```

### `addMessageId`

Метод добавляет один или несколько (в таком случае передавайте массив) `message_id` к объекту пересылаемого сообщения.

```php
$forward->addMessageId(200) // добавить 200-ый message_id
$forward->addMessageId([201, 230, 500]) // добавить 201 230 500 message_id
```

### `json`

Метод возволяет получить `JSON-объект` для передачи его в метод `API`.

```php
$forward->json()
```

{% hint style="info" %}
Метод json() используется только в случае вызова "сырых" запросов к API.\
Методы-утилиты sendMessage() и answer() принимают полноценный объект Forward, а после самостоятельно вызывают этот метод.
{% endhint %}
