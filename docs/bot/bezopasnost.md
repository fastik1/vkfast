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

# Безопасность

Если вы хотите обезопасить себя от поддельных событий, то в настройках `Callback API` можно задать так называемый `secret` - поле с этим значением будет дополнительно приходить в событии под этим ключом.

Библиотека позволяет задать такой `secret`. Если он будет установлен, то все события, которые приходят, будут проверяться на наличие такого поля с заданным значением. Если `secret` отсутствует или не совпадает с нужным значением - обработка перкратится.

```php
use Fastik1\Vkfast\Api\VkApi;
use Fastik1\Vkfast\Bot\VkBot;
use Fastik1\Vkfast\Bot\Events\MessageNew;

$api = new VkApi('access_token', 5.131);
$bot = new VkBot($api);

$bot->setSecret('your_super_secret');
```

{% hint style="info" %}
Задать секретный ключ можно через Настройки группы => Работа с API => Настройки сервера => Секретный ключ (внизу)
{% endhint %}
