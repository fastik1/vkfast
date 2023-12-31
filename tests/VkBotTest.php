<?php

namespace Fastik1\Vkfast\Tests;

require_once __DIR__ . '/ExampleTestClassForEventHandlers.php';

use Fastik1\Vkfast\Api\VkApi;
use Fastik1\Vkfast\Bot\Events\Confirmation;
use Fastik1\Vkfast\Bot\Events\MessageNew;
use Fastik1\Vkfast\Bot\Rules\IsChatMessageBaseRule;
use Fastik1\Vkfast\Bot\Rules\IsPrivateMessageBaseRule;
use Fastik1\Vkfast\Bot\Rules\BaseRule;
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
        $this->bot->on(MessageNew::class, function (MessageNew $event) {});

        $this->assertCount(1, $this->bot->handlers_message_new);
    }

    /**
     * Тест на добавление нового события "message_new" с помощью хелпера message() для обработки всех событий данного типа
     * Порядок проверки: отсутствие доп. правил (rules) для добавленного события
     */
    public function test_message_method()
    {
        $this->bot->message(function (MessageNew $event) {});

        $this->assertEmpty($this->bot->handlers_message_new[0]->rules);
    }

    /**
     * Тест на добавление нового события "message_new" с помощью хелпера privateMessage() только для обработки личных сообщений
     * Порядок проверки: наличие правил (rules), наличие правила IsPrivateMessageRule
     */
    public function test_privateMessage_method()
    {
        $this->bot->privateMessage(function (MessageNew $event) {});

        $this->assertNotEmpty($this->bot->handlers_message_new[0]->rules);

        $is_finded_rule = false;
        foreach ($this->bot->handlers_message_new[0]->rules as $rule) {
            if (IsPrivateMessageBaseRule::class == $rule::class) {
                $is_finded_rule = true;
            }
        }
        $this->assertTrue($is_finded_rule);
    }

    /**
     * Тест на добавление нового события "message_new" с помощью хелпера privateMessage() только для обработки сообщений из чата
     * Порядок проверки: наличие правил (rules), наличие правила IsChatMessageRule
     */
    public function test_chatMessage_method()
    {
        $this->bot->chatMessage(function (MessageNew $event) {});

        $this->assertNotEmpty($this->bot->handlers_message_new[0]->rules);

        $is_found_rule = false;
        foreach ($this->bot->handlers_message_new[0]->rules as $rule) {
            if (IsChatMessageBaseRule::class == $rule::class) {
                $is_found_rule = true;
            }
        }
        $this->assertTrue($is_found_rule);
    }

    /**
     * Тест метода continueProcessing, который делает обработчик обязательным, даже если другой обработчик уже сработал
     */
    public function test_continueProcessing_method()
    {
        $this->expectOutputString(self::OK);

        $test_is_call_1 = false;
        $this->bot->on(MessageNew::class, function (MessageNew $event) use (&$test_is_call_1) {$test_is_call_1 = true;}); // необязательный обработчик, который сработает

        $test_is_call_2 = false;
        $this->bot->on(MessageNew::class, function (MessageNew $event) use (&$test_is_call_2) {$test_is_call_2 = true;})->continueProcessing(); // обязательный обработчик, который должен сработать в любом случае на это событие

        $test_is_call_3 = false;
        $this->bot->on(MessageNew::class, function (MessageNew $event) use (&$test_is_call_3) {$test_is_call_3 = true;}); // необязательный обработчик, который уже не сработает, т.к. сработал первый обработчик

        $this->assertFalse($this->bot->handlers_message_new[0]->continueProcessing);
        $this->assertTrue($this->bot->handlers_message_new[1]->continueProcessing);
        $this->assertFalse($this->bot->handlers_message_new[2]->continueProcessing);

        $this->bot->run($this->event_message_new);

        $this->assertTrue($test_is_call_1);
        $this->assertTrue($test_is_call_2);
        $this->assertFalse($test_is_call_3);
    }

    /**
     * Тест на проверку возврата пустой строки если callback-функция вернула пустую строку
     */
    public function test_return_empty_string_callback_function()
    {
        $this->expectOutputString('');

        $this->bot->on(MessageNew::class, function (MessageNew $event) {
            return '';
        });

        $this->bot->run($this->event_message_new);
    }

    /**
     * Тест на проверку возврата 'ok' в случае, если callback-функция вернула null
     */
    public function test_return_null_callback_function()
    {
        $this->expectOutputString(self::OK);

        $this->bot->on(MessageNew::class, function (MessageNew $event) {
            return null;
        });

        $this->bot->run($this->event_message_new);
    }

    /**
     * Тест на проверку возврата 'ok' в случае, если callback-функция ничего не вернула
     */
    public function test_no_return_callback_function()
    {
        $this->expectOutputString(self::OK);

        $this->bot->on(MessageNew::class, function (MessageNew $event) {});

        $this->bot->run($this->event_message_new);
    }

    /**
     * Тест на проверку возврата bool в случае, если callback-функция вернула bool
     * @dataProvider returnBoolCallbackFunction
     */
    public function test_return_bool_callback_function(bool $value)
    {
        $this->expectOutputString((string) $value);

        $this->bot->on(MessageNew::class, function (MessageNew $event) use ($value) {
            return $value;
        });

        $this->bot->run($this->event_message_new);
    }

    public static function returnBoolCallbackFunction(): array
    {
        return [
            [true],
            [false],
        ];
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
     * Тест вызова метода класса при поступлении события "message_new"
     */
    public function test_event_message_new_handler_for_class_method()
    {
        $this->expectOutputString(ExampleTestClassForEventHandlers::RETURN);

        $this->bot->on(MessageNew::class, [ExampleTestClassForEventHandlers::class, 'messageNewHandler']);

        $this->bot->run($this->event_message_new);
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
     * Порядок проверки: проверка на НЕ пустоту массива с правилами, проверка на является ли первое правило инстансом добавленного правила
     */
    public function test_add_rule()
    {
        $this->expectOutputString('');

        $this->bot->on(MessageNew::class, function () {})
            ->rule(new IsPrivateMessageBaseRule);

        $this->assertNotEmpty($this->bot->handlers_message_new[0]->rules);
        $this->assertInstanceOf(IsPrivateMessageBaseRule::class, $this->bot->handlers_message_new[0]->rules[0]);
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
        })->rule(new IsPrivateMessageBaseRule);

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
        })->rule(new IsChatMessageBaseRule);

        $this->bot->run($this->event_message_new);

        $this->assertFalse($test_is_call);
    }
}
