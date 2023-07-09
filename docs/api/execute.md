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

# Метод execute

В этом методе API используется магический метод `__invoke`.

```php
$execute = $api->execute;
$response = $execute('return true;');

// или

$response = ($api->execute)('return true;');
```
