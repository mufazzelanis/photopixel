<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeadReceived extends Notification
{
    use Queueable;

    public function __construct(
        public Model $lead,
        public string $label,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject("New {$this->label} — Pixel Graphic Studio")
            ->greeting("New {$this->label}");

        foreach ($this->lead->getAttributes() as $key => $value) {
            if (in_array($key, ['id', 'updated_at', 'ip', 'status', 'admin_note'])) {
                continue;
            }
            if (blank($value)) {
                continue;
            }
            $mail->line('**'.ucwords(str_replace('_', ' ', $key)).':** '.(is_string($value) ? $value : json_encode($value)));
        }

        return $mail->line('Open the admin panel to respond.');
    }
}
