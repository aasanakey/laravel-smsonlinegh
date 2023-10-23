<?php

namespace Aasanakey\Smsonline\Composer;

use Aasanakey\Smsonline\Utils\PhoneUtil;

trait SMSComposer
{
    protected $destiantions = [];

    protected $varsPattern = "/\{\\$[a-zA-Z_][a-zA-Z0-9]+\}/";

    protected $message;

    protected $personalised = false;

    public function addDestination($phoneNumber)
    {
        if (is_null($phoneNumber) || empty($phoneNumber)) {

            throw new \Exception('Invalid value for adding message destination.');
        }

        if (!PhoneUtil::isValidPhoneNumber($phoneNumber)) {
            throw new \Exception("'{$phoneNumber}' is not a valid phone number.");
        }

        array_push($this->destiantions,['to'=>$phoneNumber]);
        return $this;
    }

    public function addDestinationFromList(array $phoneNumbers)
    {
        foreach ($phoneNumbers as $phoneNumber) {
            $this->addDestination($phoneNumber);
        }
        return $this;
    }

    // public function addPersonalisedDestination($phoneNumber, array $values)
    // {
    //     if (is_null($phoneNumber) || empty($phoneNumber)) {

    //         throw new \Exception('Invalid value for adding message destination.');
    //     }

    //     if (!PhoneUtil::isValidPhoneNumber($phoneNumber)) {
    //         throw new \Exception("'{$phoneNumber}' is not a valid phone number.");
    //     }

    //     array_push($this->destiantions,['to'=>$phoneNumber,'values' => $values]);
    // }

    public function addPersonalisedDestination($phoneNumber, $values, $messageId = null) {
        if (is_null($phoneNumber) || empty($phoneNumber) || !PhoneUtil::isValidPhoneNumber($phoneNumber)){// Exception can be thrown
            throw new \Exception('Invalid phone number for adding personalised message values.');
        }
       
        // the message should be set for personalising
        if (!$this->isPersonalised()) {
            throw new \Exception('Message is not personalised to add values.');
        }
        
        // also validate the personalised values
        $this->assertPersonalisedValues($phoneNumber, $values);
        array_push($this->destiantions,['to'=>$phoneNumber,'values' => $values]);
        return $this;
    }

    public function getMessageVariables($messageText, $trim = true){
        $vars = array(); 
        $varsList = array();
        
        if (!is_null($messageText) && !empty($messageText)) {
            preg_match_all($this->varsPattern, $messageText, $vars, PREG_SET_ORDER);        

            foreach ($vars as $var){
                $tempVar = $var[0];

                if ($trim === true)
                    $tempVar = $this->trimVariable ($tempVar);

                $varsList[] = $tempVar;
            }
        }
        
        return $varsList;
    }

    private function trimVariable($variable){
        // define pattern for trimming
        $pattern = "/[\{\}\$]/";
        
        // trim
        return preg_replace($pattern, '', $variable);
    }

    private function assertPersonalisedValues($phoneNumber, &$values){
        if (is_null($values) || !is_array($values) || count($values) == 0) {            
            throw new \Exception('Invalid reference to personalised values.');
        }
        
        // the message text should have already been set.
        if (is_null($this->message) || empty($this->message)) {
            throw new \Exception('Message text has not been set for validating personalised values.');
        }
        
        $varsList = $this->getMessageVariables($this->message);
        
        if (is_null($varsList) || count($varsList) != count($values)){
            throw new \Exception('Mismatch variables and values count.');
        }

        // all values must be provided
        for ($i = 0; $i < count($values); ++$i){
            $val = $values[$i];

            if (is_null($val)){
                $pos = $i + 1;
                throw new \Exception("Invalid personalised value at position '{$pos}' for phone number '{$phoneNumber}'.");
            }
        }
        
        return $this;
    }
    
    public function isPersonalised()
    {
        return $this->personalised;
    }

    public function personalised()
    {
       $this->personalised = true;
       return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
