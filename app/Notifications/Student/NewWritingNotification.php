<?php

namespace App\Notifications\Student;

use App\Models\User;
use App\Models\Writing;
use Illuminate\Bus\Queueable;
use App\Models\ComponentScore;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewWritingNotification extends Notification
{
    use Queueable;
    public $writing;
    public $teacher;
    public $type;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $teacher, Writing $writing, $type)
    {
        $this->teacher = $teacher;
        $this->writing = $writing;
        $this->type = $type;
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
            'title'     => $this->type == 'stacked' ? 'New Writing' : 'Writing Updated ' . optional($this->teacher)->username . ' (' . $this->teacher->name . ')',
            'message'   => $this->writing->book->title . '<br>' . $this->writing->component->parent->name . '<br>' . $this->writing->component->name,
            'link'      => route('student.essay.show', $this->writing->book_id) . '?component='. $this->writing->component_id,
            'avatar'    => $this->teacher->avatar
        ];
    }

    public function toBroadcast($notifiable) {
        return new BroadcastMessage([
            'title'     => $this->type == 'stacked' ? 'New Writing' : 'Writing Updated ' . optional($this->teacher)->username . ' (' . $this->teacher->name . ')',
            'message'   => $this->writing->book->title . "\n" . $this->writing->component->parent->name .  "\n" . $this->writing->component->name,
            'link'      => route('student.essay.show', $this->writing->book_id) . '?component='. $this->writing->component_id,
            'avatar'    => $this->teacher->avatar
        ]);
    }
}
