<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\PostingApproval;
use App\Stage;

class PostingApproved extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $stage;
      public $posting_approval;
    public function __construct(Stage $stage,PostingApproval $posting_approval)
    {
        //
        $this->stage=$stage;
        $this->posting_approval=$posting_approval;
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

//'You are to review and approve a request for a document '.$this->document_request_approval->document_request->title.' applied for by '.$this->document_request->user->name

         return (new MailMessage)
        ->subject('Posting Approved')
        ->line('The Posting Request for , '.$this->posting_approval->posting->user->name.' which you requested for  on the '.date('Y-m-d',strtotime($this->posting_approval->posting->created_at)).'('.\Carbon\Carbon::parse($this->posting_approval->posting->created_at)->diffForHumans().') has been approved at the final stage')

        ->action('View Postings', url("postings/index"))
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
              'subject'=>'Posting Approved',
            'message'=>'The Posting Request for , '.$this->posting_approval->posting->user->name.' which you requested for  on the '.date('Y-m-d',strtotime($this->posting_approval->posting->created_at)).'('.\Carbon\Carbon::parse($this->posting_approval->posting->created_at)->diffForHumans().') has been approved at the final stage',
            'action'=>url("postings/index"),
            'type'=>'Postings',
            'icon'=>'md-file-text'
        ]);

    }
}
