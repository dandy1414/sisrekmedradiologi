<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TagihanNotifikasi extends Notification
{
    use Queueable;

    protected $new_tagihan;
    protected $nama_pasien_tagihan;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($new_tagihan, $nama_pasien_tagihan)
    {
        $this->new_tagihan = $new_tagihan;
        $this->nama_pasien_tagihan = $nama_pasien_tagihan;
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

    public function toDatabase($notifiable)
    {
        return [
            'tagihan' => $this->new_tagihan,
            'nama_pasien' => $this->nama_pasien_tagihan
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
