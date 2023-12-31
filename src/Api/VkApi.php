<?php

namespace Fastik1\Vkfast\Api;

use Fastik1\Vkfast\Exceptions\VkApiException;
use Fastik1\Vkfast\Traits\CreateEntities;
use Fastik1\Vkfast\Traits\UtilsApiMethods;

/**
 * @property \Fastik1\Vkfast\Api\Methods\Account account()
 * @property \Fastik1\Vkfast\Api\Methods\Ads ads()
 * @property \Fastik1\Vkfast\Api\Methods\AppWidgets appWidgets()
 * @property \Fastik1\Vkfast\Api\Methods\Apps apps()
 * @property \Fastik1\Vkfast\Api\Methods\Asr asr()
 * @property \Fastik1\Vkfast\Api\Methods\Auth auth()
 * @property \Fastik1\Vkfast\Api\Methods\Board board()
 * @property \Fastik1\Vkfast\Api\Methods\Bugtracker bugtracker()
 * @property \Fastik1\Vkfast\Api\Methods\Calls calls()
 * @property \Fastik1\Vkfast\Api\Methods\Database database()
 * @property \Fastik1\Vkfast\Api\Methods\Docs docs()
 * @property \Fastik1\Vkfast\Api\Methods\Donut donut()
 * @property \Fastik1\Vkfast\Api\Methods\DownloadedGames downloadedGames()
 * @property \Fastik1\Vkfast\Api\Methods\Execute execute()
 * @property \Fastik1\Vkfast\Api\Methods\Fave fave()
 * @property \Fastik1\Vkfast\Api\Methods\Friends friends()
 * @property \Fastik1\Vkfast\Api\Methods\Gifts gifts()
 * @property \Fastik1\Vkfast\Api\Methods\Groups groups()
 * @property \Fastik1\Vkfast\Api\Methods\LeadForms leadForms()
 * @property \Fastik1\Vkfast\Api\Methods\Likes likes()
 * @property \Fastik1\Vkfast\Api\Methods\Market market()
 * @property \Fastik1\Vkfast\Api\Methods\Messages messages()
 * @property \Fastik1\Vkfast\Api\Methods\Newsfeed newsfeed()
 * @property \Fastik1\Vkfast\Api\Methods\Notes notes()
 * @property \Fastik1\Vkfast\Api\Methods\Notifications notifications()
 * @property \Fastik1\Vkfast\Api\Methods\Orders orders()
 * @property \Fastik1\Vkfast\Api\Methods\Pages pages()
 * @property \Fastik1\Vkfast\Api\Methods\Photos photos()
 * @property \Fastik1\Vkfast\Api\Methods\Podcasts podcasts()
 * @property \Fastik1\Vkfast\Api\Methods\Polls polls()
 * @property \Fastik1\Vkfast\Api\Methods\PrettyCards prettyCards()
 * @property \Fastik1\Vkfast\Api\Methods\Search search()
 * @property \Fastik1\Vkfast\Api\Methods\Secure secure()
 * @property \Fastik1\Vkfast\Api\Methods\Stats stats()
 * @property \Fastik1\Vkfast\Api\Methods\Status status()
 * @property \Fastik1\Vkfast\Api\Methods\Storage storage()
 * @property \Fastik1\Vkfast\Api\Methods\Store store()
 * @property \Fastik1\Vkfast\Api\Methods\Stories stories()
 * @property \Fastik1\Vkfast\Api\Methods\Streaming streaming()
 * @property \Fastik1\Vkfast\Api\Methods\Users users()
 * @property \Fastik1\Vkfast\Api\Methods\Utils utils()
 * @property \Fastik1\Vkfast\Api\Methods\Video video()
 * @property \Fastik1\Vkfast\Api\Methods\Wall wall()
 * @property \Fastik1\Vkfast\Api\Methods\Widgets widgets()
 */
class VkApi
{
    use UtilsApiMethods, CreateEntities;

    private VkApiRequest $request;
    private array $instances = [];

    public function __construct(string $access_token, float $version, bool $ignore_error = false)
    {
        $this->request = new VkApiRequest($access_token, $version, $ignore_error);
    }

    public function __get(string $name): mixed
    {
        $class = '\\Fastik1\\Vkfast\\Api\\Methods\\' . ucwords($name);
        if (!class_exists($class)) {
            throw new VkApiException("Class {$class} not found");
        }

        if (!array_key_exists($name, $this->instances)) {
            $this->instances[$name] = new $class($this->request);
        }

        return $this->instances[$name];
    }

    public function getRequest(): VkApiRequest
    {
        return $this->request;
    }

}