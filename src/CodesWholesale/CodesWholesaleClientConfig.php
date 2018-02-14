<?php

/**
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Lesser General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace CodesWholesale;

use CodesWholesale\Exceptions\ClientConfigException;
use CodesWholesale\Storage\Storage;
use Sainsburys\Guzzle\Oauth2\GrantType\PasswordCredentials;

class CodesWholesaleClientConfig
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var array
     */
    private $clientHeaders;

    /**
     * @var array
     */
    private $clientData;

    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var string
     */
    private $signature;

    /**
     * @var string
     */
    private $clientId;

    public function __construct(array $data)
    {
        if (!isset($data)) {
            throw new ClientConfigException("no configuration found");
        }

        foreach (array('cw.client_id', 'cw.client_secret', 'cw.endpoint_uri', 'cw.token_storage') as $key) {
            if (!isset($data[$key])) {
                throw new ClientConfigException(sprintf("missing field '%s'", $key));
            }
        }

        if (isset($data['cw.signature'])) {
            $this->signature = $data['cw.signature'];
        }
        $this->clientId = $data['cw.client_id'];
        $this->baseUrl = $data['cw.endpoint_uri'];
        $this->storage = $data['cw.token_storage'];
        $this->clientData = array(
            PasswordCredentials::CONFIG_CLIENT_SECRET => $data['cw.client_secret'],
            PasswordCredentials::CONFIG_CLIENT_ID => $data['cw.client_id'],
            PasswordCredentials::CONFIG_TOKEN_URL => $data['cw.endpoint_uri'] . '/oauth/token',
            'scope' => 'administration',
        );

        $this->clientHeaders = isset($data['cw.client.headers']) ? $data['cw.client.headers'] : array();
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }


    /**
     * @return mixed
     */
    public function getClientHeaders()
    {
        return $this->clientHeaders;
    }

    /**
     * @return Storage|mixed
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @return array
     */
    public function getClientData()
    {
        return $this->clientData;
    }

    /**
     * @return mixed|string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return mixed|string
     */
    public function getSignature()
    {
        return $this->signature;
    }

}
