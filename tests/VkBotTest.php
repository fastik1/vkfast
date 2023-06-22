<?php

namespace Fastik1\Vkfast\Tests;

use Fastik1\Vkfast\Api\VkApi;
use Fastik1\Vkfast\Bot\Events\Confirmation;
use Fastik1\Vkfast\Bot\Events\MessageNew;
use Fastik1\Vkfast\Bot\Rules\IsChatMessageRule;
use Fastik1\Vkfast\Bot\Rules\IsPrivateMessageRule;
use Fastik1\Vkfast\Bot\Rules\Rule;
use Fastik1\Vkfast\Bot\VkBot;
use PHPUnit\Framework\TestCase;

class VkBotTest extends TestCase
{
    protected VkBot $bot;
    protected VkApi $api;

    /*
     * Строка, которую возвращает библиотека при базовой обработке события
     * Является меткой для Callback VK API, что событие успешно получено
     */
    const OK = 'ok';

    /**
     * Объект события, который приходит при событии "message_new"
     */
    protected array $event_message_new = [
        "group_id" => 201026442,
        "type" => "message_new",
        "event_id" => "883541ca9fa9d981ac37b674a02fe1d310ec6092",
        "v" => "5.131",
        "object" => [
            "message" => [
                "date" => 1686577491,
                "from_id" => 201283295,
                "id" => 114,
                "out" => 0,
                "attachments" => [
                ],
                "conversation_message_id" => 113,
                "fwd_messages" => [
                ],
                "important" => false,
                "is_hidden" => false,
                "peer_id" => 201283295,
                "random_id" => 0,
                "text" => "Hello"
            ],
            "client_info" => [
                "button_actions" => [
                    "text",
                    "vkpay",
                    "open_app",
                    "location",
                    "open_link",
                    "callback",
                    "intent_subscribe",
                    "intent_unsubscribe"
                ],
                "keyboard" => true,
                "inline_keyboard" => true,
                "carousel" => true,
                "lang_id" => 0
            ]
        ]
    ];

    /**
     * Объект события, который приходит при событии "confirmation" (подтверждение callback-адреса)
     */
    protected array $event_confirmation = [
        "group_id" => 201026442,
        "event_id" => "883541ca9fa9d981ac37b674a02fe1d310ec6092",
        "v" => "5.131",
        "type" => "confirmation"
    ];

    protected function setUp(): void
    {
        $this->api = new VkApi('access_token', 5.131);
        $this->bot = new VkBot($this->api);
    }

    protected function tearDown(): void
    {
        unset($this->api, $this->bot);
    }

    /**
     * Тест на добавление нового события
     * Порядок проверки: отсутствие событий, добавилось ли событие
     */
    public function test_on_method()
    {
        $this->assertCount(0, $this->bot->getHandlers());

        $this->bot->on(MessageNew::class, function (MessageNew $event) {});

        $this->assertCount(1, $this->bot->getHandlers());
    }

    /**
     * Тест на добавление нового события "message_new" с помощью хелпера message() для обработки всех событий данного типа
     * Порядок проверки: отсутствие событий, добавилось ли событие, отсутствие доп. правил (rules) для добавленного события
     */
    public function test_message_method()
    {
        $this->assertCount(0, $this->bot->getHandlers());

        $this->bot->message(function (MessageNew $event) {});

        $this->assertCount(1, $this->bot->getHandlers());
        $this->assertArrayNotHasKey('rules', $this->bot->getHandlers()[0]);
    }

    /**
     * Тест на добавление нового события "message_new" с помощью хелпера privateMessage() только для обработки личных сообщений
     * Порядок проверки: отсутствие событий, добавилось ли событие, наличие правил (rules), наличие правила IsPrivateMessageRule
     */
    public function test_privateMessage_method()
    {
        $this->assertCount(0, $this->bot->getHandlers());

        $this->bot->privateMessage(function (MessageNew $event) {});

        $this->assertCount(1, $this->bot->getHandlers());
        $this->assertArrayHasKey('rules', $this->bot->getHandlers()[0]);

        $is_finded_rule = false;
        foreach ($this->bot->getHandlers()[0]['rules'] as $rule) {
            if (IsPrivateMessageRule::class == $rule::class) {
                $is_finded_rule = true;
            }
        }
        $this->assertTrue($is_finded_rule);
    }

    /**
     * Тест на добавление нового события "message_new" с помощью хелпера privateMessage() только для обработки сообщений из чата
     * Порядок проверки: отсутствие событий, добавилось ли событие, наличие правил (rules), наличие правила IsChatMessageRule
     */
    public function test_chatMessage_method()
    {
        $this->assertCount(0, $this->bot->getHandlers());

        $this->bot->chatMessage(function (MessageNew $event) {});

        $this->assertCount(1, $this->bot->getHandlers());
        $this->assertArrayHasKey('rules', $this->bot->getHandlers()[0]);

        $is_found_rule = false;
        foreach ($this->bot->getHandlers()[0]['rules'] as $rule) {
            if (IsChatMessageRule::class == $rule::class) {
                $is_found_rule = true;
            }
        }
        $this->assertTrue($is_found_rule);
    }
    
    /**
     * Тест вызова callback-функции при поступлении события "message_new"
     */
    public function test_event_message_new_handler()
    {
        $this->expectOutputString(self::OK);

        $is_call = false;

        $this->bot->on(MessageNew::class, function (MessageNew $event) use (&$is_call) {
            $is_call = true;
        });

        $this->bot->run($this->event_message_new);

        $this->assertTrue($is_call);
    }

    /**
     * Тест вызова callback-функции и возврата значения callback-функции при поступлении события "confirmation"
     */
    public function test_event_confirmation_handler()
    {
        $this->expectOutputString('confirmation');

        $is_call = false;

        $this->bot->on(Confirmation::class, function (Confirmation $event) use (&$is_call) {
            $is_call = true;
            return 'confirmation';
        });

        $this->bot->run($this->event_confirmation);

        $this->assertTrue($is_call);
    }

    /**
     * Тест вызова callback-функции при поступлении команды разной, но валидной формы
     * @dataProvider calledCommandCallbackFunctionProvider
     */
    public function test_called_command_callback_function(string $textMessage)
    {
        $this->expectOutputString(self::OK);

        $this->bot->setPrefix('!');

        $this->event_message_new['object']['message']['text'] = $textMessage;

        $test_is_call = false;

        $this->bot->on(MessageNew::class, function (MessageNew $event, $command, ...$arguments) use (&$test_is_call) {
            $test_is_call = true;
        })->command('debug');

        $this->bot->run($this->event_message_new);

        $this->assertTrue($test_is_call);
    }

    public static function calledCommandCallbackFunctionProvider()
    {
        return [
            ['!debug'],
            [' !debug'],
            ['!debug '],
            ['!debug parameter1 parameter2 parameter3'],
            [' !debug parameter1 parameter2 parameter3'],
            ['!debug  parameter1 parameter2 parameter3'],
            ['!debug parameter1 parameter2 '],
            [' !debug parameter1 parameter2 '],
            ['!debug  parameter1 parameter2'],
            ['!debug parameter1 parameter2'],
            [' !debug parameter1 parameter2'],
            ['!debug  parameter1 parameter2'],
        ];
    }

    /**
     * Тест отсутствия вызова callback-функции при поступлении команды не валидной команды
     * @dataProvider notCalledCommandCallbackFunctionProvider
     */
    public function test_not_called_command_callback_function(string $textMessage)
    {
        $this->expectOutputString(self::OK);

        $this->bot->setPrefix('!');

        $this->event_message_new['object']['message']['text'] = $textMessage;

        $test_is_call = false;

        $this->bot->on(MessageNew::class, function (MessageNew $event, $command, ...$arguments) use (&$test_is_call) {
            $test_is_call = true;
        })->command('debug');

        $this->bot->run($this->event_message_new);

        $this->assertFalse($test_is_call);
    }

    public static function notCalledCommandCallbackFunctionProvider(): array
    {
        return [
            ['debug'],
            [' debug'],
            ['debug '],
            ['debug parameter1 parameter2 parameter3'],
            [' debug parameter1 parameter2 parameter3'],
            ['debug  parameter1 parameter2 parameter3'],
            ['debug parameter1 parameter2 '],
            [' debug parameter1 parameter2 '],
            ['debug  parameter1 parameter2'],
            ['debug parameter1 parameter2'],
            [' debug parameter1 parameter2'],
            ['debug  parameter1 parameter2'],
        ];
    }

    /**
     * Тест обработки валидных команд и правильном возврате аргументов
     * Порядок проверки: вызов callback-функции, является ли переменная массивом, есть ли в массиве нужные индексы, правильно ли распределены в массиве аргументы команды
     * @dataProvider argumentsCommandCallbackFunctionProvider
     */
    public function test_arguments_command_callback_function(string $textMessage)
    {
        $this->expectOutputString(self::OK);

        $this->bot->setPrefix('!');

        $this->event_message_new['object']['message']['text'] = $textMessage;

        $test_is_call = false;
        $test_command = null;
        $test_arguments = null;

        $this->bot->on(MessageNew::class, function (MessageNew $event, $command, ...$arguments) use (&$test_is_call, &$test_command, &$test_arguments) {
            $test_is_call = true;
            $test_command = $command;
            $test_arguments = $arguments;
        })->command('debug');

        $this->bot->run($this->event_message_new);

        $this->assertTrue($test_is_call);
        $this->assertIsArray($test_arguments);
        $this->assertArrayHasKey(0, $test_arguments);
        $this->assertArrayHasKey(1, $test_arguments);
        $this->assertArrayHasKey(2, $test_arguments);
        $this->assertEquals('parameter1', $test_arguments[0]);
        $this->assertEquals('parameter2', $test_arguments[1]);
        $this->assertEquals('parameter3', $test_arguments[2]);
    }

    public static function argumentsCommandCallbackFunctionProvider(): array
    {
        return [
            ['!debug parameter1 parameter2 parameter3'],
            ['!debug parameter1 parameter2  parameter3'],
            ['!debug parameter1  parameter2 parameter3'],
            [' !debug parameter1 parameter2 parameter3'],
            ['!debug parameter1    parameter2 parameter3'],
            ['!debug parameter1 parameter2 parameter3   '],
            ['!debug   parameter1 parameter2 parameter3'],
            ['! debug parameter1 parameter2 parameter3'],
        ];
    }

    /**
     * Тест на добавление правила
     * Порядок проверки: добавление нового обработчика, наличие внутри массива с правилами, проверка на НЕ пустоту первого правила, проверка на является ли первое правило инстансом добавленного правила
     */
    public function test_add_rule()
    {
        $this->expectOutputString('');

        $this->bot->on(MessageNew::class, function () {})
            ->rule(new IsPrivateMessageRule);

        $this->assertArrayHasKey(0, $this->bot->getHandlers());
        $this->assertArrayHasKey('rules', $this->bot->getHandlers()[0]);
        $this->assertNotEmpty($this->bot->getHandlers()[0]['rules'][0]);
        $this->assertInstanceOf(IsPrivateMessageRule::class, $this->bot->getHandlers()[0]['rules'][0]);
    }

    /**
     * Тест на работу правила
     * Базовое событие "message_new" является личным сообщением, поэтому правило IsPrivateMessageRule должно сработать и запустить callback-функцию
     */
    public function test_called_callback_function_with_rule()
    {
        $this->expectOutputString(self::OK);

        $test_is_call = false;

        $this->bot->on(MessageNew::class, function (MessageNew $event) use (&$test_is_call) {
            $test_is_call = true;
        })->rule(new IsPrivateMessageRule);

        $this->bot->run($this->event_message_new);

        $this->assertTrue($test_is_call);
    }

    /**
     * Тест на работу правила
     * Базовое событие "message_new" является личным сообщением, поэтому правило IsChatMessageRule НЕ должно сработать и НЕ запустить callback-функцию
     */
    public function test_not_called_callback_function_with_rule()
    {
        $this->expectOutputString(self::OK);

        $test_is_call = false;

        $this->bot->on(MessageNew::class, function (MessageNew $event) use (&$test_is_call) {
            $test_is_call = true;
        })->rule(new IsChatMessageRule);

        $this->bot->run($this->event_message_new);

        $this->assertFalse($test_is_call);
    }
}
