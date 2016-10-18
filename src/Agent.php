<?php
namespace Onerecharge;
use GuzzleHttp\Client;

/**
 * This is an Agent object instance.
 */

class Agent{
    
    private $key;
    private $authorization;
    private $domain;
    
    /**
     * Create a new agent object instance.
     * @param string $key `API ACCESS KEY` from your agent dashboard
     * @param string $token Access token can be created via static function Agent::getToken()
     * @param string $domain Endpoint domain name to communicate with. during integration test. This is configured to use the test server
     */
    public function __construct($key, $token, $domain = Util::TEST_DOMAIN) {
        $this->key = $key;
        $this->authorization = $token;
        $this->domain = $domain;
    }
    
    function getKey() {
        return $this->key;
    }

    function getDomain() {
        return $this->domain;
    }
    
    function getAuthorization() {
        return $this->authorization;
    }
   
    /**
     * Gets an Authorization token on the fly
     * @param string $agent_id The agent login id - usually email
     * @param string $password The agent password
     * @param string $domain Endpoint domain name to communicate with. during integration test. This is configured to use the test server
     * @return object NULL if authorization failed or @string authorization token if successful
     */
    public static function getToken($agent_id, $password, $domain = Util::TEST_DOMAIN){
        $client = new Client();
        $result = $client->get($domain.'/api/auth/'.$agent_id."/".$password);
        if($result->getStatusCode() == 200){
            return json_decode($result->getBody())->data;
        }
        return NULL;
    }
}
