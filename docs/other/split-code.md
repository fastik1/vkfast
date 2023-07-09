---
description: Очень важная тема!
coverY: 0
layout:
  cover:
    visible: true
    size: full
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

# Разделение кода

Все мы писали когда-то ботов в одном файле... Помните, как это ужасно? Именно поэтому важно разделение логики в коде на разные блоки.

Предлагаю вам такую структуру:

* app
  * Commands - классы команд
  * Handlers - обработчики
    * ConfirmationHandler.php
    * GroupEvents.php
    * KeyboardEvents.php
  * Rules
    * isAdminChatRule
  * Bot.php
* index.php
