<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Posting;

class ApprovePosting extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $posting;
    public function __construct(Posting $posting)
    {
        //

        $this->posting=$posting;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
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
            ->subject('Approve Staff Posting')
            ->line('You are to review and approve a request for a   '.$this->posting->posting_type->name.' requested for '.$this->posting->user->name)
            ->line('Kindly review the request as it is suppose to be effective '.date('F j, Y',strtotime($this->posting->effective_date)))
            // ->action('View Document Request', url('/postings/approvals'))
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
            'subject'=>'Approve Posting' ,
            'details'=>"<ul class=\"list-group list-group-bordered\">
<li class=\"list-group-item \"><strong>Created By:</strong><span style\"text-align:right\">".$this->posting->creator->name."</span></li>
                  <li class=\"list-group-item \"><strong>Employee:</strong><span style\"text-align:right\">".$this->posting->user->name."</span></li>
                  <li class=\"list-group-item  \"><strong>Posting Type:</strong><span style\"text-align:right\">".$this->posting->posting_type->name."</span></li>
                  <li class=\"list-group-item  \"><strong>Document Due Date:</strong><span style\"text-align:right\">".date('F j, Y',strtotime($this->posting->effective_date))."</span></li>
                   </ul>",
            'message'=>'You are to review and approve a request for a   '.$this->posting->posting_type->name.' requested for '.$this->posting->user->name,
            'action'=>url('postings/approvals'),
            'type'=>'Posting',
            'icon'=>'md-file-text'
        ]);

    }
}
