<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Interfaces\MethodInterface;
use Fastik1\Vkfast\Utils;
use Fastik1\Vkfast\Api\VkApiRequest;

/**
 * @method getChairs(...$arguments)
 * @method getCities(...$arguments)
 * @method getCitiesById(...$arguments)
 * @method getCountries(...$arguments)
 * @method getCountriesById(...$arguments)
 * @method getFaculties(...$arguments)
 * @method getMetroStations(...$arguments)
 * @method getMetroStationsById(...$arguments)
 * @method getRegions(...$arguments)
 * @method getSchoolClasses(...$arguments)
 * @method getSchools(...$arguments)
 * @method getUniversities(...$arguments)
 */
class Database implements MethodInterface
{
    private VkApiRequest $request;

    public function __construct(VkApiRequest $request)
    {
        $this->request = $request;
    }

    public function __call($method, $parameters)
    {
        if (isset($parameters[0])) {
            if (is_array($parameters[0])) {
                $parameters = $parameters[0];
            }
        }
        return $this->request->apiRequest(Utils::classNameToMethod(__CLASS__) . '.' . $method, $parameters);
    }
}

