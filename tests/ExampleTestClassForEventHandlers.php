<?php


namespace Fastik1\Vkfast\Tests;


use Fastik1\Vkfast\Bot\Events\Event;

/**
 * Класс для теста VkBotTest test_event_message_new_handler_for_class_method
 * В случае выполнения метода messageNewHandler() возвращает строку, которая проверяется на выходе
 * Если строка соответствует ожидаемой строке (метод вызвался при поступлении события) - все нормально
 * Это НЕ пример по обработке события, это лишь тестовый класс для теста
 */
class ExampleTestClassForEventHandlers
{
    const RETURN = 'call';

    public function messageNewHandler(Event $event): string
    {
        return self::RETURN;
    }
}