<?php

namespace Onerecharge;
use Onerecharge\Agent;
use GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request;

/**
 * Use this class to initiate a bill payment
 */
class BillPayment{
    
    private $agent;
    private $client;
    
    /**
     * 
     * @param Agent $agent Pass a valid Agent instance to initialize bill payment
     */
    public function __construct(Agent $agent) {
        $this->agent = $agent;
        $this->client = new Client();
    }
    
    /**
     * Do an airtime topup
     * @param string $recipient valid telephone number without country code
     * @param string $telco network name
     * @param int $amount amount to recharge
     * @return string Success if topup was successful or @see string error/fault message 
     */
    public function airtimeTopup($recipient, $telco, $amount){
        $uri = $this->agent->getDomain()."/api/recharge/new";
        $headers = array(
            "Authorization"=> $this->agent->getAuthorization(),
            "Key"=>  $this->agent->getKey(),
            "Content-Type"=> "application/json");
        $body = array(
            "recipient"=> $recipient,
            "amount"=> (int) $amount,
            "network"=> $telco
        );
        $request = new Request('POST', $uri, $headers, json_encode($body));
        $topup_response = $this->client->send($request);
        if($topup_response->getStatusCode() == 200){
            $body = json_decode($topup_response->getBody());
            if($body->status){
                /**
                 * recharge was successful. get the reference ID and start attempting to get status
                 * as soon as onerecharge completes processing request
                 */
                $reference = $body->data->reference;
                $pending = true;
                do{
                    sleep(2);//Maximum expected time to complete processing of a request is 2 seconds.
                    $confirm_transaction = json_decode($this->client->get($this->agent->getDomain().
                            "/api/recharge/tranx/".$reference)->getBody());
                    if(isset($confirm_transaction->data->response)){
                        if($confirm_transaction->data->successful){
                            return "Success";
                        }
                        else{
                            return $confirm_transaction->data->response_description;
                        }
                    }
                }while($pending);
            }
            else{
                return $body->data->message;
            }
        }
        return "Something went wrong communicating with platform, Try again later";
    }
}

