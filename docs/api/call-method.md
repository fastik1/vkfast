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

# Вызов методов API

Вызов методов `API` реализуется использованием сначала первой части метода `API` (секции, например `groups`) в виде атрибута объекта `VkApi`, а после второй части метода `API` (например, `ban`), в виде метода объекта `VkApi`.

По итогу получается конструкция вида:

```php
$api->groups->ban(...)
```

Параметры метода `API` могут указываться как именованные аргументы объекта, так и как ассоциативный массив в первом аргументе:

```php
->method(parameter1: 'value1', parameter2: 'value2')
->method(['parameter1' => 'value1', 'parameter2' => 'value2'])
```
