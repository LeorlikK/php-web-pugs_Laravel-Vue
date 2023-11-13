<?php

namespace Notifications;

use App\Models\User;
use App\Notifications\FeedbackMailNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_feedback()
    {
        $userAdmin = User::factory(1)->create(
        [
            'login' => 'lerolikTestMailAdmin',
            'email' => 'lerolikTestMailAdmin@yandex.ru',
            'role' => 'admin'
        ]);
        $userNotAdmin = User::factory(1)->create(
            [
                'login' => 'lerolikTestMailNotAdmin',
                'email' => 'lerolikTestMailNotAdmin@yandex.ru',
                'role' => 'user'
            ]);

        $feedback = 'Test mail message';

        $userAdmin->notify(new FeedbackMailNotification($userNotAdmin->email, $feedback));
        Notification::assertSentTo(
            [$userAdmin], FeedbackMailNotification::class
        );
    }
}
