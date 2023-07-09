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

# Обработка событий

Для того, чтобы обработать какое-то конкретное событие от `Callback API`, для него необходимо добавить обработчик.

```php
use Fastik1\Vkfast\Api\VkApi;
use Fastik1\Vkfast\Bot\VkBot;
use Fastik1\Vkfast\Bot\Events\MessageNew;

$api = new VkApi('access_token', 5.131);
$bot = new VkBot($api);

$bot->on(MessageNew::class, function (MessageNew $event) {
    // обработка события message_new
});

$bot->run(); // запуск обработки события
```

Также, возможно передать вместо `callback-функции` массив с `классом и его методом` - именно метод указанного класса и будет вызван как `callback-функция`.

```php
class Handler
{
    public function messageNew(MessageNew $event)
    {
        // обработка события message_new
    }
}

$bot->on(MessageNew::class, [Handler::class, 'messageNew']);
```

{% hint style="warning" %}
Важно, чтобы метод класс был публичным (public).
{% endhint %}

{% hint style="info" %}
Полезно для разделения кода. Рекомендуется использовать именно такой подход.
{% endhint %}

## Событие confirmation

Как вы знаете, чтобы настроить `Callback API` приложение на событие `confirmation`  должно вернуть специальный короткий токен, который можно найти в меню настройки `Callback API`. Но как вернуть этот токен при обработке события? Очень просто. Достаточно внутри callback-функции сделать `return` с необходимым `string` или `int` значением.

Подобно применимо к любым обработчикам, но зачастую, подобное необходимо именно для события `confirmation`.

```php
use Fastik1\Vkfast\Bot\Events\Confirmation;

class Handler
{
    public function confirmation(Confirmation $event)
    {
        return '1d8fb851' // вернет в браузер вместо базового 'ok' эту строчку и прекратит дальнейшую обработку
    }
}

$bot->on(Confirmation::class, [Handler::class, 'confirmation']);
```

{% hint style="info" %}
В случае, если callback-функция возвращает string или int - дальнейшая обработка полностью прекращается и происходит отдача результата в браузер.
{% endhint %}

## Метод `run()`

Именно этот метод запускает обработку ранее зарегистрированных обработчиков. Без него ничего работать не будет, т.к. мы только зарегистрировали определенные обработчики, но не запустили их обработку.

```php
$bot->run();

// or

$bot->run($rawEvent);
```

{% hint style="info" %}
У метода есть единственный аргумент, который принимает сырое событие, которое вы можете самостоятельно передать на обрабортку. По умолчанию библиотека сама получает событие через file\_get\_contents('php://input')
{% endhint %}

{% hint style="danger" %}
Используйте метод run() только один раз в своем приложении, иначе произойдет двойная обработка одного и того же события.
{% endhint %}
