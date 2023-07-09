---
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

# Хелперы

## Обертка над методом `on()`

Для обработки всех сообщений, сообщений из чата и из лички в классе присутствуют три хелпера.

```php
$bot->message(function (MessageNew $event) {
    // обработка всех сообщений
});

$bot->chatMessage(function (MessageNew $event) {
    // обработка сообщений из чата
});

$bot->privateMessage(function (MessageNew $event) {
    // обработка сообщений из лички
});
```

## Хелпер `answer()` события message\_new

Метод answer() присуствует только при обработке события message\_new. Служит для быстрого ответа в тот же чат, откуда пришло событие. Является оберткой над методом утилитой sendMessage класса VkApi.

```php
$bot->message(function (MessageNew $event) {
    $event->answer('Привет!')
});
```
