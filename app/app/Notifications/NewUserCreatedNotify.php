<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class NewUserCreatedNotify extends Notification implements  ShouldQueue
{
    use Queueable;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user=$user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject('Account Created on HCMatrix')
            ->line('This is to notify you that an account has been created for you on HCMatrix')
                    ->line('Your login details are:')
            ->line('Email: '.$this->user->email)
            ->line('Password: Root1234')
            ->line('Kindly change your password from the default when logged in.')
                    ->action('Access your account', url('/'))
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

//    public function toDatabase($notifiable){
//        return new DatabaseMessage([
//            'subject'=>'New Poll Created' ,
//            'details'=>"A new Poll has been created",
//            'message'=>'You are to take part in this Poll',
//            'action'=>route('respond.poll',$this->poll_id),
//            'type'=>'New Poll',
//            'icon'=>'md-file-text'
//        ]);
//
//    }
}
