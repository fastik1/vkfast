<?php

namespace Fastik1\Vkfast\Api\Methods;

use Fastik1\Vkfast\Api\VkApiRequest;
use Fastik1\Vkfast\Utils;

/**
 * @method addOfficeUsers(...$arguments)
 * @method checkLink(...$arguments)
 * @method createAds(...$arguments)
 * @method createCampaigns(...$arguments)
 * @method createClients(...$arguments)
 * @method createLookalikeRequest(...$arguments)
 * @method createTargetGroup(...$arguments)
 * @method createTargetPixel(...$arguments)
 * @method deleteAds(...$arguments)
 * @method deleteCampaigns(...$arguments)
 * @method deleteClients(...$arguments)
 * @method deleteTargetGroup(...$arguments)
 * @method deleteTargetPixel(...$arguments)
 * @method getAccounts(...$arguments)
 * @method getAds(...$arguments)
 * @method getAdsLayout(...$arguments)
 * @method getAdsPostsReach(...$arguments)
 * @method getAdsTargeting(...$arguments)
 * @method getBudget(...$arguments)
 * @method getCampaigns(...$arguments)
 * @method getCategories(...$arguments)
 * @method getClients(...$arguments)
 * @method getDemographics(...$arguments)
 * @method getFloodStats(...$arguments)
 * @method getLookalikeRequests(...$arguments)
 * @method getMusicians(...$arguments)
 * @method getMusiciansByIds(...$arguments)
 * @method getOfficeUsers(...$arguments)
 * @method getPostsReach(...$arguments)
 * @method getRejectionReason(...$arguments)
 * @method getStatistics(...$arguments)
 * @method getSuggestions(...$arguments)
 * @method getTargetGroups(...$arguments)
 * @method getTargetPixels(...$arguments)
 * @method getTargetingStats(...$arguments)
 * @method getUploadURL(...$arguments)
 * @method getVideoUploadURL(...$arguments)
 * @method importTargetContacts(...$arguments)
 * @method removeOfficeUsers(...$arguments)
 * @method removeTargetContacts(...$arguments)
 * @method saveLookalikeRequestResult(...$arguments)
 * @method shareTargetGroup(...$arguments)
 * @method updateAds(...$arguments)
 * @method updateCampaigns(...$arguments)
 * @method updateClients(...$arguments)
 * @method updateOfficeUsers(...$arguments)
 * @method updateTargetGroup(...$arguments)
 * @method updateTargetPixel(...$arguments)
 */
class Ads extends Method
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

