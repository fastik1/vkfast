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

# Метод continueProcessing()

Метод позволяет зарегистрировать такой обработчик, который сработает на событие в любом случае, даже если на текущее событие уже сработал другой обработчик

```php
$bot->message(function (MessageNew $event) {
    // обработка всех сообщений
})->continueProcessing(); // регистрация обработчика, который сработает на событие в любом случае
```

{% hint style="info" %}
Полезно для регистрации обработчика, который будет обрабатывать абсолютно все сообщения в чате для каких-то целей. Например, для проверки на маты.

При этом, такой обработчик не будет мешать другим обработчикам.
{% endhint %}
