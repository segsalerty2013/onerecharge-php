<?php

require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Onerecharge\Agent;
use Onerecharge\Util;
use Onerecharge\BillPayment;

class OnerechargeTest extends TestCase{
    
    private $agent_id = "anuonasile@gmail.com";
    private $password = "password";
    private $key = "oZFLQVYpRO9Ur8i6H8Q1J5c3RMgt0fb0";
    
    public function testGetAvailableNetworks(){
        $this->assertNotEmpty(Util::getSupportedBillType());
    }
    
    /**
     * @depends testGetAvailableNetworks
     */
    public function testGetToken(){
        $token = Agent::getToken($this->agent_id, $this->password);
        $this->assertNotNull($token);
        return $token;
    }
    
    /**
     * @depends testGetToken
     */
    public function testInstantRecharge(){
        $agent = new Agent($this->key, func_get_arg(0));
        $billpayment = new BillPayment($agent);
        $this->assertEquals("Success", $billpayment->airtimeTopup("08025444373", "Etisalat", 100));
    }
}
