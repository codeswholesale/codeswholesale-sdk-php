<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 21/09/2017
 * Time: 20:50
 */

namespace CodesWholesale\Storage;

use Sainsburys\Guzzle\Oauth2\AccessToken;

interface Storage
{
    public function storeAccessToken(AccessToken $accessToken, $clientConfigId);

    /**
     * @param string $clientConfigId
     * @return AccessToken
     */
    public function getAccessToken($clientConfigId);

    public function deleteAccessToken(AccessToken $accessToken, $clientConfigId);

}