<?php
namespace Aasanakey\Smsonline\Tests;

use Illuminate\Support\Facades\Notification;

class SmsTest extends TestCase {

    public function test_it_can_send_sms()
    {
        Notification::fake();
        $user = new User([
            'email' => 'test@mail.com',
            'phone' => '02354555555'
        ]);
        
        $user->notify(new TestNotification());
        Notification::assertSentTo($user,TestNotification::class);
        //$this->assertTrue(true);
    }
}