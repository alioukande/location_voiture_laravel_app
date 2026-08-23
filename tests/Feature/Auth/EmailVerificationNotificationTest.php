<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailVerificationNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_notification_can_be_sent(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)
            ->post('/email/verification-notification');

        $response->assertRedirect();

        Notification::assertSentTo(
            $user,
            VerifyEmail::class
        );
    }
}