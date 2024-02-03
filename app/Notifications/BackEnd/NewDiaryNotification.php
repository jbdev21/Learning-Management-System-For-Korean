<?php

namespace App\Notifications\BackEnd;

use Carbon\Carbon;
use App\Models\Diary;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewDiaryNotification extends Notification
{
    use Queueable;
    public $diary;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Diary $diary)
    {
        $this->diary = $diary;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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


     public function toDatabase($notifiable)
    {
        return [
            'title'     => 'New Diary',
            'message'   => optional($this->diary->user)->username . ' (' . ($this->diary->user)->name . ')',
            'link'      => route('back-end.diary.show', $this->diary->id),
            'avatar'    => $this->diary->user->avatar,
            'created_at'    => Carbon::now(),
        ];
    }

    public function toBroadcast($notifiable) {
        return new BroadcastMessage([
            'title'     => 'New Diary',
            'message'   =>  optional($this->diary->user)->username . ' (' . ($this->diary->user)->name . ')',
            'link'      => route('back-end.diary.show', $this->diary->id),
            'avatar'    => $this->diary->user->avatar,
            'created_at'    => Carbon::now()
        ]);
    }
}
