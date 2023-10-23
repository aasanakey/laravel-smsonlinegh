<?php
namespace Aasanakey\Smsonline;

class SmsonlineSmsMessage extends SMS {
    
    protected $personalisedValues;

    public function sender($sender)
    {
        // $sender = $sender ?? config('smsonline.sender_id');
        $this->setSenderId($sender);
        return $this;
    }

    public function content($message)
    {
        $this->setMessage($message);
        return $this;
    }

    public function personalisedValues(array $values)
    {
        $this->personalised();
        $this->personalisedValues = $values;
        return $this;
    }

    public function getPersonalisedData()
    {
        return $this->personalisedValues;
    }
}