<?php

namespace Aasanakey\Smsonline;

use Exception;
use Illuminate\Support\Facades\Http;
use Aasanakey\Smsonline\Enum\Handshake;
use Aasanakey\Smsonline\Enum\TextMessageType;
use Aasanakey\Smsonline\Composer\SMSComposer;


class SMS
{
    use SMSComposer;

    /**
     * smsonlinegh api host
     *
     * @var mixed
     */
    private $host;

    /**
     * smsonline api access key
     *
     * @var mixed
     */
    private $api_key;

    /**
     * sms sender name
     *
     * @var mixed
     */
    private $sender_id;

    /**
     * smsonline sms sending api endpoint
     *
     * @var string
     */
    private $send_endpoint = "/message/sms/send";

    /**
     * smsonline sms delivery report api endpoint
     *
     * @var string
     */
    private $delivery_endpoint = "/report/message/delivery";

    /**
     * smsonline sms balance report api endpoint
     *
     * @var string
     */
    private $balance_endpoint = "/report/balance";

    // private $message;

    private $message_type;

    // private $recipients = [];

    private $balance = null;

    public function __construct()
    {
        if (!config('smsonline.host')) {
            throw new Exception('smsonline api host is not defined');
        }

        if (!config('smsonline.api_key')) {
            throw new Exception('smsonline api key is not defined');
        }

        if (!config('smsonline.sender_id')) {
            throw new Exception('smsonline sms sender id is not defined');
        }

        $this->host = config('smsonline.host');
        $this->api_key = config('smsonline.api_key');
        $this->sender_id = config('smsonline.sender_id');
    }

    /**
     * Get full requets end point     *
     * @param  mixed $url
     * @return string
     */
    private function getEndpoint(string $url)
    {
        $base_url = rtrim($this->host, '/');
        $path = ltrim($url, '/');
        return urldecode(join('/', [$base_url, 'v4', $path]));
    }

    private function validateParams()
    {
        if(is_null($this->message)){
            throw new Exception('Message is not set.');
        }

        if(is_null($this->message_type)){
            throw new Exception('Message type is not set.');
        }

        if(is_null($this->sender_id)){
            throw new Exception('Message sender name is not set.');
        }
    }

    /**
     * Set new sender id value 
     *
     * @param  string $sender_id
     * @return \Aasanakey\Smsonline\SmsOnline
     */
    public function setSenderId(string $sender_id)
    {
        $this->sender_id = $sender_id;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function setMessageType($type = null)
    {
        switch ($type) {
            case null:
                $this->message_type = TextMessageType::TEXT;
                break;

            default:
                if (!TextMessageType::isDefined($type)) {
                    throw new Exception('Invalid message type.');
                }
                $this->message_type = $type;
                break;
        }
        return $this;
    }

    public function isMessageTypeSet()
    {
        return !is_null($this->message_type) || !empty($this->message_type);
    }

    public function send()
    {
        $this->validateParams();
        $data = [
            "messages" => [
                [
                    "text" => $this->getMessage(),
                    "type" => $this->message_type,
                    "sender" => $this->sender_id,
                    "destinations" => $this->destiantions,
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "key $this->api_key",
        ])->post($this->getEndpoint($this->send_endpoint), $data);
        return $response->json();
    }

    public function balance()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Authorization' => "key $this->api_key",
        ])->get($this->getEndpoint($this->balance_endpoint));
        $res_obj = $response->object();
        $hshk  = $res_obj->handshake;
        if ($hshk->id === Handshake::HSHK_OK) {
            $this->balance = $res_obj->data->balance;
            return $res_obj->data->balance;
        }
        return $response->json();
    }

    public function currencyName()
    {
        if ($this->balance)
            return $this->balance->currencyName;
        return null;
    }

    public function currencyCode()
    {
        if ($this->balance)
            return $this->balance->currencyCode;
        return null;
    }

    public function amount()
    {
        if ($this->balance)
            return $this->balance->amount;
        return null;
    }
}
