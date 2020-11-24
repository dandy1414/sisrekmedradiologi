<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpertisePoliNotifikasi extends Notification
{
    use Queueable;

    protected $expertise;
    protected $nama_pasien;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($expertise, $nama_pasien)
    {
        $this->expertise = $expertise;
        $this->nama_pasien = $nama_pasien;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'expertise' => $this->expertise,
            'nama_pasien' => $this->nama_pasien
        ];
    }
}
