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

# User

Возможно, вам уже надоело самостоятельно создавать упоминания и ссылки на пользователей в тексте? Сущность `User` избавит вас от этого!

## Инициализация

{% code title="Конструктор" %}
```php
public function __construct(VkApi $api, int $id) {}
```
{% endcode %}

Сущность `User` можно инициализировать двумя способами.

1. Вручную, указав необходимые параметры в конструкторе класса, использовав `new`
2. Использовать метод класса `VkApi`, дабы избавиться себя от указания инстанса этого класса

### 1 способ

```php
use Fastik1\Vkfast\Api\VkApi;
use Fastik1\Vkfast\Api\Entities\User;

$api = new VkApi(...);
$user = new User($api, 325654); // создаст сущность User с user_id 325654
```

### 2 способ

<pre class="language-php"><code class="lang-php"><strong>use Fastik1\Vkfast\Api\VkApi;
</strong>use Fastik1\Vkfast\Api\Entities\User;

$api = new VkApi(...);
$user = $api->user(325654); // создаст сущность User с user_id 325654
</code></pre>

## Методы

### `mention`

Создаст упоминание с `ID` пользователя (который указывался при инициализации). В первом аргументе можно указать необходимый текст упоминания.

```php
$user->mention(); // строчка вида @id325654
$user->mention('упоминание'); // строчка вида @id325654 (упоминание)
```

### `mentionWithFullName`

Создаст упоминание с полным именем и фамилией пользователя. В первом аргументе возможно указать падеж, по умолчанию `nom`. Все падежи находятся [здесь](https://dev.vk.com/method/users.get).

```php
$user->mentionWithFullName(); // строчка вида @id325654 (Имя Фамилия в род. падеже)
```

### `mentionWithFirstName`

Аналог `mentionWithFullName`, но в упоминании будет только имя.

### `mentionWithLastName`

Аналог `mentionWithFullName`, но в упоминании будет только фамилия.

### `isDeactivated`

Метод проверяет, деактивирована ли страница пользователя по какой-то причине.

```php
$user->isDeactivated(); // true || false
```

### `isBanned`

Метод проверяет, забанена ли страница пользователя (аналог `isDeactivated`, но с конкретикой).

```php
$user->isBanned(); // true || false
```

### `isDeleted`

Метод проверяет, удалена ли страница пользователя (аналог `isDeactivated`, но с конкретикой).

```php
$user->isDeleted(); // true || false
```

### `getUsersGet`

Метод возвращает объект запроса к методу `API` `users.get`, если необходима какая-то информация оттуда.

```php
$user->getUsersGet(); // object:
// {
//    "id": id,
//    "first_name": "Имя",
//    "last_name": "Фамилия",
//    "can_access_closed": bool,
//    "is_closed": bool,
// }
```

### `refresh`

Заново получает объект `users.get`, т.к. в угоду оптимизации такой запрос выполняется лишь один раз (если каждый раз падеж один и тот же), а после просто отдается из ранее сохраненного атрибута.

```php
$user->isDeleted(); // например false

/**
    ...
    например, пользователь в процессе удалил страницу
    ...
*/

$user->isDeleted(); // вернет все также false, т.к. объект users.get сохранен в "кэше"

$user->refresh()->isDeleted(); // вернет true, т.к. объект users.get был заново получен
```
