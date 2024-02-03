<?php

namespace App\Notifications\BackEnd;

use Carbon\Carbon;
use App\Models\Writing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewWritingNotification extends Notification
{
    use Queueable;
    public $writing;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Writing $writing)
    {
        $this->writing = $writing;
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
            'title'     => 'New Writing ' . optional($this->writing->writingStudent)->username . ' (' . ($this->writing->writingStudent)->name . ')',
            'message'   =>  $this->writing->book->title . '<br>' . $this->writing->component->parent->name . '<br>' . $this->writing->component->name,
            'link'      => '/back-end/writing/show?component='. $this->writing->component_id . '&book=' . $this->writing->book_id . '&student=' . $this->writing->student,
            'avatar'    => $this->writing->user->avatar,
            'created_at'    => Carbon::now(),
        ];
    }

    public function toBroadcast($notifiable) {
        return new BroadcastMessage([
            'title'     => 'New Writing ' . optional($this->writing->writingStudent)->username . ' (' . ($this->writing->writingStudent)->name . ')',
            'message'   =>  $this->writing->book->title . "\n" . $this->writing->component->parent->name .  "\n" . $this->writing->component->name,
            'link'      => '/back-end/writing/show?component='. $this->writing->component_id . '&book=' . $this->writing->book_id . '&student=' . $this->writing->student,
            'avatar'    => $this->writing->user->avatar,
            'created_at'    => Carbon::now()
        ]);
    }


}
