<?php

namespace App\Notifications;

use App\Models\Candidature;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CandidatureStatusUpdatedNotification extends Notification
{
    use Queueable;

    protected Candidature $candidature;
    protected string $status;

    public function __construct(Candidature $candidature, string $status)
    {
        $this->candidature = $candidature;
        $this->status = $status;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'status' => $this->status,
            'offre_title' => $this->candidature->offre?->titre ?? 'Offre',
            'company_name' => $this->candidature->offre?->companyProfile?->nom_entreprise ?? 'Entreprise',
        ];
    }

    public function toArray($notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
