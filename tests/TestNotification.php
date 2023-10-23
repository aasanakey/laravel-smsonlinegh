<?php

namespace Aasanakey\Smsonline\Tests;

use Illuminate\Notifications\Notification;
use Aasanakey\Smsonline\SmsonlineSmsMessage;

class TestNotification extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['smsonlinegh'];
    } 

    /**
     * Get the sms message for the notification.
     *
     * @param  mixed  $notifiable
     * @return \NotificationChannels\WebPush\WebPushMessage
     */
 
    public function toSmsonline($notifiable)
    {
        return (new SmsonlineSmsMessage)
            // ->sender('Sender ID')
            ->content("Your verification code is 256655");
    }
}