<?php
namespace Aasanakey\Smsonline;

use Illuminate\Notifications\Notification;

class SmsonlineChannel{

    public function send ($notifiable, Notification $notification) {
        
        if (method_exists($notifiable, 'routeNotificationForSmsonline')) {
            $number = $notifiable->routeNotificationForSmsonline($notifiable);
        } else {
            throw new \Exception("notifiable contact number not found. Return the contact number in the routeNotificationForSmsonline method in your model", 1);
        }

        $message = method_exists($notification, 'toSmsonline')
            ? $notification->toSmsonline($notifiable)
            : $notification->toArray($notifiable);
        if (is_null($message) || empty($message)) {
            throw new \Exception("toSmsonline method must return an instance of \Aasanakey\Smsonline\SmsonlineSmsMessage::class.", 1);
        }
       
       if($message->isPersonalised()){
            $values = $message->getPersonalisedData();
            $message->addPersonalisedDestination($number,$values);
       }else {
            $message->addDestination($number);
       }
       if(!$message->isMessageTypeSet()){
            $message->setMessageType();
       }
        
        $response = $message->send();

        return $response;
    }
}