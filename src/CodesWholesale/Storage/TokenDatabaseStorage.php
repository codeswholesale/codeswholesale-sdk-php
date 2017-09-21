<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 21/09/2017
 * Time: 22:45
 */

namespace CodesWholesale\CodesWholesale\Storage;

use CodesWholesale\Storage\Storage;
use PDO;
use Sainsburys\Guzzle\Oauth2\AccessToken;

class TokenDatabaseStorage implements Storage
{
    /** @var PDO */
    private $db;

    /** @var string */
    private $prefix;

    public function __construct(PDO $db, $prefix = "")
    {
        $this->db = $db;
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->prefix = $prefix;
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
                'expires_in' => $result['expires_in']
            ]);
        }
        return false;
    }

    public function storeAccessToken(AccessToken $accessToken, $clientConfigId)
    {
        $stmt = $this->db->prepare(
            sprintf(
                "INSERT INTO %s (client_config_id, scope, access_token, token_type, expires_in) VALUES(:client_config_id, :scope, :access_token, :token_type, :expires_in)",
                $this->prefix . 'access_tokens'
            )
        );
        $stmt->bindValue(":client_config_id", $clientConfigId, PDO::PARAM_STR);
        $stmt->bindValue(":scope", $accessToken->getScope(), PDO::PARAM_STR);
        $stmt->bindValue(":access_token", $accessToken->getToken(), PDO::PARAM_STR);
        $stmt->bindValue(":token_type", $accessToken->getType(), PDO::PARAM_STR);
        $stmt->bindValue(":expires_in", $accessToken->getExpires()->getTimestamp(), PDO::PARAM_INT);

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

    public static function createTableQueries($prefix)
    {
        $query = array();
        $query[] = sprintf(
            "CREATE TABLE IF NOT EXISTS %s (
                client_config_id VARCHAR(255) NOT NULL,
                user_id VARCHAR(255) NOT NULL,
                scope VARCHAR(255) NOT NULL,
                issue_time INTEGER NOT NULL,
                access_token VARCHAR(255) NOT NULL,
                token_type VARCHAR(255) NOT NULL,
                expires_in INTEGER DEFAULT NULL,
                UNIQUE (client_config_id , user_id , scope)
            )",
            $prefix . 'access_tokens'
        );
        return $query;
    }
    public function initDatabase()
    {
        $queries = self::createTableQueries($this->prefix);
        foreach ($queries as $q) {
            $this->db->query($q);
        }

        $tables = array('access_tokens');
        foreach ($tables as $t) {
            // make sure the tables are empty
            $this->db->query(
                sprintf(
                    "DELETE FROM %s",
                    $this->prefix . $t
                )
            );
        }
    }
}