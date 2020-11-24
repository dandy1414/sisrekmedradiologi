<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendaftaranNotifikasi extends Notification
{
    use Queueable;

    protected $pemeriksaan;
    protected $nama_pasien;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pemeriksaan, $nama_pasien)
    {
        $this->pemeriksaan = $pemeriksaan;
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
            'pemeriksaan' => $this->pemeriksaan,
            'nama_pasien' => $this->nama_pasien
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
