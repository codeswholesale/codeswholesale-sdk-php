<?php

namespace CodesWholesale\Resource;

use CodesWholesale\Client;
use CodesWholesale\CodesWholesale;
use function CodesWholesale\toObject;

class Webhook extends Resource
{
    const WEBHOOK = "webhook";

    const WEBHOOK_ENDPOINT_V2 = "/webhook";

    public static function update($newWebhook)
    {
        Client::put(self::WEBHOOK_ENDPOINT_V2, json_encode([
            "webhook" => $newWebhook
        ]));
    }

    public static function delete()
    {
        Client::delete(self::WEBHOOK);
    }

    /**
     * @return \CodesWholesale\Resource\Webhook|object
     * @throws \Exception
     */
    public static function get()
    {
        return Client::get(self::WEBHOOK_ENDPOINT_V2, CodesWholesale::WEBHOOK);
    }

    /**
     * @return string
     */
    public function getWebhook()
    {
        return $this->getProperty(self::WEBHOOK);
    }
}