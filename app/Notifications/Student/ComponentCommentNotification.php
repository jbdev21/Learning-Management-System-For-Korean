<?php

namespace App\Notifications\Student;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ComponentCommentNotification extends Notification
{
    use Queueable;
    public $teacher, $url, $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $teacher, $url, $message)
    {
        $this->teacher = $teacher;
        $this->url = $url;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
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
            'title'     => 'New Comment ' . ($this->teacher)->username  . ' (' . ($this->teacher)->name . ')',
            'message'   => $this->message,
            'link'      => $this->url,
            'avatar'    => $this->teacher->avatar,
            'created_at'    => Carbon::now(),
        ];
    }

    public function toBroadcast($notifiable) {
        return new BroadcastMessage([
            'title'     => 'New Comment ' . ($this->teacher)->username  . ' (' . ($this->teacher)->name . ')',
            'message'   => $this->convertBrToN(),
            'link'      => $this->url,
            'avatar'    => $this->teacher->avatar,
            'created_at'    => Carbon::now(),
        ]);
    }

    private function convertBrToN(){
        $array = explode('<br>', $this->message);
        $string = '';
        foreach($array as $array){
            $string .= $array . "\n";
        }
        return $string;
    }
}
