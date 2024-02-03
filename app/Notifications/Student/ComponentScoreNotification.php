<?php

namespace App\Notifications\Student;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Models\ComponentScore;
use App\Models\Writing;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ComponentScoreNotification extends Notification
{
    use Queueable;
    public $score;
    public $writing;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ComponentScore $score, Writing $writing)
    {
        $this->score = $score;
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
            'title'     => 'Book Writing Score ' . ($this->score->teacher)->username . ' (' . ($this->score->teacher)->name . ")",
            'message'   => $this->writing->book->title . '<br>' . $this->writing->component->parent->name . '<br>' . $this->writing->component->name,
            'link'      => '/my-dashboard/essay/' .  $this->score->book_id . '?component=' . $this->score->component_id,
            'avatar'    => $this->score->teacher->avatar,
            'created_at'    => Carbon::now(),
        ];
    }

    public function toBroadcast($notifiable) {
        return new BroadcastMessage([
            'title'     => 'Book Writing Score ' . ($this->score->teacher)->username . ' (' . ($this->score->teacher)->name . ")",
            'message'   =>  $this->writing->book->title . "\n" . $this->writing->component->parent->name .  "\n" . $this->writing->component->name,
            'link'      => '/my-dashboard/essay/' .  $this->score->book_id . '?component=' . $this->score->component_id,
            'avatar'    => $this->score->teacher->avatar,
            'created_at'    => Carbon::now(),
        ]);
    }
}
