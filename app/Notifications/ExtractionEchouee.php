<?php

namespace App\Notifications;

use App\Models\Recu;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExtractionEchouee extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Recu $recu,
        public string $errorMessage,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Échec de l\'extraction : '.$this->recu->title)
            ->greeting('Bonjour,')
            ->line('L\'extraction des dépenses a échoué pour le reçu suivant :')
            ->line('**'.$this->recu->title.'**')
            ->line('')
            ->line('Cause : '.$this->errorMessage)
            ->line('')
            ->action('Voir le reçu', route('recus.show', $this->recu))
            ->line('Vous pouvez relancer l\'extraction depuis la page du reçu.')
            ->salutation('L\'équipe Assistant Dépenses');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'recu_id' => $this->recu->id,
            'title' => $this->recu->title,
            'error_message' => $this->errorMessage,
        ];
    }
}
