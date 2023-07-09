---
description: Здесь мы создадим первого нашего бота!
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

# Первый бот

## Инициализация необходимых классов

```php
$api = new VkApi('access_token', 5.131);
$bot = new VkBot($api);
```

## Добавим обработчик

```php
$bot->message(function (MessageNew $event) {
    $event->answer('Твой текст: ' . $event->message->text);
});
```

Простой эхо-бот готов!

## Добавим команду

```php
$bot->message(function (MessageNew $event, $command, ...$arguments) { // ...$arguments - это все аргументы в виде массива
    $text = implode(' ', $arguments); // склеиваем все аргументы пробелом
    $event->answer('Аргументы команды: ' . $text);
})->command('echo'); // команда !echo
```

{% hint style="info" %}
По умолчанию префикс будет "!", изменить его можно через $bot->setPrefix()
{% endhint %}

