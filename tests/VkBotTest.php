<?php

namespace Fastik1\Vkfast\Tests;

use Fastik1\Vkfast\Api\VkApi;
use Fastik1\Vkfast\Bot\Events\Confirmation;
use Fastik1\Vkfast\Bot\Events\MessageNew;
use Fastik1\Vkfast\Bot\Rules\IsChatMessageRule;
use Fastik1\Vkfast\Bot\Rules\IsPrivateMessageRule;
use Fastik1\Vkfast\Bot\VkBot;
use PHPUnit\Framework\TestCase;

class VkBotTest extends TestCase
{
    protected VkBot $bot;
    protected VkApi $api;
    const OK = 'ok';
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

    public function test_on_method()
    {
        $this->assertCount(0, $this->bot->getHandlers());

        $this->bot->on(MessageNew::class, function (MessageNew $event) {});

        $this->assertCount(1, $this->bot->getHandlers());
    }

    public function test_message_method()
    {
        $this->assertCount(0, $this->bot->getHandlers());

        $this->bot->message(function (MessageNew $event) {});

        $this->assertCount(1, $this->bot->getHandlers());
        $this->assertArrayNotHasKey('rules', $this->bot->getHandlers()[0]);
    }

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
     * @dataProvider CalledCommandCallbackFunction
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

    public static function CalledCommandCallbackFunction()
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
     * @dataProvider NotCalledCommandCallbackFunction
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

    public static function NotCalledCommandCallbackFunction(): array
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
     * @dataProvider ArgumentsCommandCallbackFunction
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

    public static function ArgumentsCommandCallbackFunction(): array
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
}
