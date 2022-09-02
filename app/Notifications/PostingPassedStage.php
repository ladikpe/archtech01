<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\PostingApproval;
use App\Stage;

class PostingPassedStage extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

   public $posting_approval;
      public $stage;
      public $nextstage;
    public function __construct(PostingApproval $posting_approval,Stage $stage,Stage $nextstage)
    {
        //
        $this->posting_approval=$posting_approval;
        $this->stage=$stage;
        $this->nextstage=$nextstage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
        ->subject('Posting Passed an Approval Stage')
        ->line('The Posting for, '.$this->posting_approval->posting->user->name.' which you submitted for approval has been approved at the '.$this->stage->name.' by '.$this->posting_approval->approver->name)
        ->line('It has been moved to the'.$this->nextstage->name)
        ->action('View Posting',  url("postings/index"))
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

        return new DatabaseMessage([
            'subject'=>' Posting Passed an Approval Stage',
            'message'=>'The Posting for, '.$this->posting_approval->posting->user->name.' which you submitted for approval has been approved at the '.$this->stage->name.' by '.$this->posting_approval->approver->name,
            'action'=>url("postings/index"),
            'type'=>'Posting',
            'icon'=>'md-file-text'
        ]);

    }
}
