<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 21/09/2017
 * Time: 20:50
 */

namespace CodesWholesale\Storage;

use Sainsburys\Guzzle\Oauth2\AccessToken;
use Sainsburys\Guzzle\Oauth2\GrantType\RefreshToken;


interface Storage
{
    public function storeAccessToken(AccessToken $accessToken);

    /**
     * @return AccessToken
     */
    public function getAccessToken();
    public function deleteAccessToken(AccessToken $accessToken);

    public function storeRefreshToken(RefreshToken $refreshToken);
    public function getRefreshToken();
    public function deleteRefreshToken(RefreshToken $refreshToken);

}