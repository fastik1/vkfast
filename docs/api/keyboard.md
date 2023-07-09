---
description: >-
  Клавиатура - это метод взаимодействия с пользователем, который упрощает жизнь
  этому самому пользователю.
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

# Клавиатура

Библиотека предоставляет билдер, с помощью которого можно собрать необходимую клавиатуру.

Типы кнопок представляются классами: `Text` `Callback` `Location` `OpenLink` `VkPay` `VkApps`. Каждый из них имеет свой конструктор с теми полями, которые необходимы для конкретного типа кнопки. Экземпляр таких классов передается в метод `add` класса `Keyboard` параметром `$action`

### Методы класса Keyboard

`add()` - добавляет кнопку к клавиатуре\
`row()` - переход на новую строку\
`remove()` - пустая клавиатура (для того, чтобы удалить ее у пользователя)\
`json()` - получение клавиатуры в виде строчного JSON-объекта

### Пример клавиатуры

```php
use Fastik1\Vkfast\Api\Keyboard\Actions\Callback;
use Fastik1\Vkfast\Api\Keyboard\Actions\Location;
use Fastik1\Vkfast\Api\Keyboard\Actions\OpenLink;
use Fastik1\Vkfast\Api\Keyboard\Actions\Text;
use Fastik1\Vkfast\Api\Keyboard\Color;
use Fastik1\Vkfast\Api\Keyboard\Keyboard;

$keyboard = new Keyboard(one_time: false, inline: true);

$keyboard->add(new Text('Green text 1'), Color::POSITIVE)
        ->add(new Text('Red text 2'), Color::NEGATIVE)
        ->add(new Text('Blue text 3'), Color::PRIMARY)
        ->add(new Text('White text 4'), Color::SECONDARY)
        ->row()
        ->add(new Callback('Callback1', ['button' => 1]), Color::POSITIVE)
        ->add(new Callback('Callback2', ['button' => 2]), Color::POSITIVE)
        ->row()
        ->add(new Location())
        ->row()
        ->add(new OpenLink('Github', 'https://github.com'));

$api->sendMessage(1, 'Hello!', $keyboard);
```
