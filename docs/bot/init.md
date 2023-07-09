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

# Инициализация

## Класс `VkBot`

{% code title="Конструктор" %}
```php
public function __construct(VkApi $api) {}

$api = new VkApi('access_token', 5.131);
$bot = new VkBot($api);
```
{% endcode %}

Для инициализации класса `VkBot` необходимо передать инициализированный класс `VkApi`, который позже будет доступен в контексте приходящих событий.

{% hint style="info" %}
Рекомендуется передавать в класс VkBot инициализированный класс VkApi с токеном той группы, от которой будут приходить события.
{% endhint %}
