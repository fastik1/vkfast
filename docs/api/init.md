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

## Класс `VkApi`

{% code title="Конструктор" %}
```php
public function __construct(
    string $access_token,
    float $version,
    bool $ignore_error = false
) {}

$api = new VkApi('access_token', 5.131);
```
{% endcode %}

{% hint style="info" %}
Если параметр <mark style="color:blue;">$ignore\_error</mark> равен <mark style="color:blue;">true</mark>, то при возникновении ошибки API будет выброшено исключение VkApiError, которое необходимо будет обработать
{% endhint %}

