<?php

namespace Onerecharge;
use GuzzleHttp\Client;

/**
 * Utility class for onerecharge
 */

class Util{
    
    const TEST_DOMAIN = "http://40.117.36.121:3001";
    
    /**
     * @param string $domain Endpoint domain name to communicate with. during integration test. This is configured to use the test server
     * @return array Returns an array of supported type of bill payments for onerecharge system.
     * Use this function to fetch the right keyword for any bill payment initiation.
     * it ruturns an empty array if error occurred or something went wrong
     */
    public static function getSupportedBillType($domain = Util::TEST_DOMAIN){
        $client = new Client();
        $result = $client->get($domain.'/api/recharge/networks');
        if($result->getStatusCode() == 200){
            $response = json_decode($result->getBody());
            if($response->status){
                return $response->data;
            }
        }
        return array();
    }
}

