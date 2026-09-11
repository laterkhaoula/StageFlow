<?php

namespace App\Notifications;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewCandidatureNotification extends Notification
{
    use Queueable;

    protected Candidature $candidature;

    public function __construct(Candidature $candidature)
    {
        $this->candidature = $candidature;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $candidateName = optional($this->candidature->studentProfile->user)->name ?? 'Candidat';
        $offerTitle = optional($this->candidature->offre)->titre ?? 'Offre';
        $date = $this->candidature->date_candidature ?? now()->toDateString();

        return [
            'candidature_id' => $this->candidature->id,
            'candidate_name' => $candidateName,
            'offre_title' => $offerTitle,
            'date_candidature' => $date,
        ];
    }

    public function toArray($notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
