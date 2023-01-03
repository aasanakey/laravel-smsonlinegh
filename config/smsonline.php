<?php
return [
    /**
     * The sms api host on which account exists
     * 
     * Eg, if website domain is thewebsite.com, 
     * then set host as api.thewebsite.com
     * 
     * For further information, read the documentation for what you should set as the host https://dev.smsonlinegh.com/
     */
    "host" => env('SMSONLINE_HOST','api.smsonlinegh.com'),

    /**
     * The smsonlinegh account api access key
     * For your account api key visit https://portal.smsonlinegh.com/account/api/options
     */
    "api_key" => env('SMSONLINE_API_KEY',null),

    /**
     * The sms message sender id to be used
     * To create a sender id visit account portal https://portal.smsonlinegh.com/message/sms/senders
     */
    "sender_id" => env('SMSONLINE_SENDER_ID',null),
];