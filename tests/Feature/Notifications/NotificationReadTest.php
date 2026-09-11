<?php

namespace Tests\Feature\Notifications;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Notification;
use Tests\TestCase;

class NotificationReadTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_mark_own_notification_as_read(): void
    {
        $user = User::factory()->create();
        $user->notify(new class extends Notification
        {
            public function via($notifiable): array
            {
                return ['database'];
            }

            public function toArray($notifiable): array
            {
                return ['message' => 'Votre candidature a été acceptée.'];
            }
        });

        $notification = $user->notifications()->first();

        $response = $this->actingAs($user)->post(route('notifications.read', $notification));

        $response->assertRedirect(route('notifications.index'));
        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_user_cannot_mark_another_users_notification_as_read(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $otherUser->notify(new class extends Notification
        {
            public function via($notifiable): array
            {
                return ['database'];
            }

            public function toArray($notifiable): array
            {
                return ['message' => 'Notification d’un autre utilisateur.'];
            }
        });

        $notification = $otherUser->notifications()->first();

        $response = $this->actingAs($user)->post(route('notifications.read', $notification));

        $response->assertForbidden();
    }
}
