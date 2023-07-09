---
description: Куда же без них...
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

# Обработка ошибок

Есть два способа обработки ошибок API.

## Способ 1

Использование конструкции try catch

```php
$api = new VkApi('access_token', 5.131, ignore_error: false); // выключаем игнор. ошибок, дабы при их наличии выбрасывалось исключение

try {
    $api->messages->send() // будет получена ошибка из-за недостаточного кол-ва аргументов
} catch (VkApiError $error) {
    $error_code = $error->getCode();
    $error_msg = $error->getMessage();
}
```

{% hint style="info" %}
Рекомендуется использовать этот способ. Так вы точно не пропустите ни одну ошибку.
{% endhint %}

{% hint style="danger" %}
Учитывайте, что все методы-утилиты, которые являются лишь обреткой над API-методами - также будут выбрасывать исключения.
{% endhint %}

## Способ 2

Ошибки API не будут выбрасывать исключения, но в объекте ответа будут присутстсовать поле error.

```php
$api = new VkApi('access_token', 5.131, ignore_error: true); // по умолчанию и так true

$request = $api->messages->send() // будет получена ошибка из-за недостаточного кол-ва аргументов
if (isset($request->error)) {
    $error_code = $request->error->error_code;
    $error_msg = $request->error->error_msg;
}
```
