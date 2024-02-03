<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewCommentNotification extends Notification
{
    use Queueable;
    public $data; 
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
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
            'title'     => 'New Comment',
            'message'   => $this->data['message'],
            // 'link'      => route('student.essay.show', ['component' => $this->writing->component_id  ,'book' => $this->writing->book_id, 'student' => $this->writing->student ]),
            'link'      =>  $this->data['link'],
            'avatar'    => $this->data['avatar'],
            'created_at'    => Carbon::now(),
        ];
    }

    public function toBroadcast($notifiable) {
        return new BroadcastMessage([
            'title'     => 'New Comment',
            'message'   => $this->data['message'],
            'link'      => $this->data['link'],
            'avatar'    => $this->data['avatar'],
            'created_at'    => Carbon::now(),
        ]);
    }
}
