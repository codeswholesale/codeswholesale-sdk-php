<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 21/09/2017
 * Time: 22:45
 */

namespace CodesWholesale\Storage;

use PDO;
use Sainsburys\Guzzle\Oauth2\AccessToken;

class TokenDatabaseStorage implements Storage
{
    /** @var PDO */
    private $db;

    /** @var string */
    private $prefix;

    /** @var string */
    private $expiration;

    public function __construct(PDO $db, $prefix = '', $expiration = 'expires_in')
    {
        $this->db = $db;
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->prefix = $prefix;
        $this->expiration = $expiration;
    }

    public function getAccessToken($clientConfigId)
    {
        $stmt = $this->db->prepare(
            sprintf(
                "SELECT * FROM %s WHERE client_config_id = :client_config_id",
                $this->prefix . 'access_tokens'
            )
        );
        $stmt->bindValue(":client_config_id", $clientConfigId, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (false !== $result) {
            return new AccessToken($result['access_token'], $result['token_type'], [
                $this->expiration => $result[$this->expiration]
            ]);
        }
        return false;
    }

    public function storeAccessToken(AccessToken $accessToken, $clientConfigId)
    {
        $stmt = $this->db->prepare(
            sprintf(
                "INSERT INTO %s (client_config_id, scope, access_token, token_type, %s) VALUES(:client_config_id, :scope, :access_token, :token_type, :expiration)",
                $this->prefix . 'access_tokens', $this->expiration
            )
        );
        $stmt->bindValue(":client_config_id", $clientConfigId, PDO::PARAM_STR);
        $stmt->bindValue(":scope", $accessToken->getScope(), PDO::PARAM_STR);
        $stmt->bindValue(":access_token", $accessToken->getToken(), PDO::PARAM_STR);
        $stmt->bindValue(":token_type", $accessToken->getType(), PDO::PARAM_STR);
        $stmt->bindValue(":expiration", $accessToken->getExpires()->getTimestamp(), PDO::PARAM_INT);

        $stmt->execute();

        return 1 === $stmt->rowCount();
    }

    public function deleteAccessToken(AccessToken $accessToken, $clientConfigId)
    {
        $stmt = $this->db->prepare(
            sprintf(
                "DELETE FROM %s WHERE client_config_id = :client_config_id AND access_token = :access_token",
                $this->prefix . 'access_tokens'
            )
        );
        $stmt->bindValue(":client_config_id", $clientConfigId, PDO::PARAM_STR);
        $stmt->bindValue(":access_token", $accessToken->getToken(), PDO::PARAM_STR);
        $stmt->execute();

        return 1 === $stmt->rowCount();
    }
}