---
description: >-
  Используются в качестве обертки над нативными методами API для более удобного
  использования в своих приложениях
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

# Методы-утилиты

### `sendMessage`

Удобное использование метода `messages.send` для отправки сообщений. Можно указывать дополнительные параметры вызова, помимо изначально заданных.

```php
sendMessage(
    int|string|array $peer_ids, // id чата/пользователя (можно указать массив)
    string|int $message, // текст сообщения
    ?Keyboard $keyboard = null, // объект клавиатуры
    ?Forward $forward = null, // объект пересланного сообщения
    bool $mentions = false, // вкл/выкл упоминания. По умолчанию упоминания выключены
    ?string $attachment = null, // вложения формата {type}{owner_id}_{media_id}
    ...$arguments // другие параметры вызова метода messages.send
)

$api->sendMessage(2000000001, 'Привет!', payload: ...) // дополнительно указываем параметр payload
$api->sendMessage(2000000001, 'Привет!', arguments: ['payload' => ...]) // дополнительно указываем параметр payload
```

### `convertUserId`

Для того, чтобы конвертировать строку вида:

```
https://vk.com/id1
https://vk.com/screenname
screenname
[id1|screenname] (так выглядит упоминание через @)
```

в обычный ID пользователя, можно использовать метод класса `VkApi`.

Например, пользователь упомянул какого-то участника или кинул ссылку на него, эту ссылку можно пропустить через метод ниже и получить чистый `ID` упомянутого пользователя. В случае неудачи определения ID будет возвращен `false`.

```php
convertUserId(string|int $value): int|bool

$api->convertUserId('https://vk.com/pavel'); // 325654
$api->convertUserId('https://vk.com/id325654'); // 325654
$api->convertUserId('[id325654|упоминание]'); // 325654
$api->convertUserId('pavel'); // 325654
```

### `isChatMember`

Метод для проверки, является ли пользователь участником определенного чата.

```php
isChatMember(
    int $user_id,
    int $peer_id
): bool

$api->isChatMember(325654, 2000000001)
```

{% hint style="info" %}
Обертка над методом messages.getConversationMembers
{% endhint %}

### `isAdminChat`

Метод для проверки наличия у пользователь админки в чате.

```php
isAdminChat(
    int $user_id,
    int $peer_id
): bool

$api->isAdminChat(325654, 2000000001)
```

{% hint style="info" %}
Обертка над методом messages.getConversationMembers
{% endhint %}

### `getGroupRole`

Метод для получения роли пользователя в определнной группе.

```php
getGroupRole(
    int $user_id,
    int $group_id
): bool|string

$api->getGroupRole(325654, 1234213134)
```

{% hint style="info" %}
Обертка над методом groups.getMembers
{% endhint %}
