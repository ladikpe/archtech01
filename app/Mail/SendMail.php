<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class SendMail extends Mailable  /*implements ShouldQueue*/
{
    use Queueable, SerializesModels;
    protected $mail_from;
    protected $mail_subject;
    protected $data;
    protected $view_template;

    /**
     * SendMail constructor.
     * @param $from
     * @param $subject
     * @param $data
     * @param string $view
     */
    public function __construct($from,$subject,$data,$view='emails.plain_mail')
    {
        $this->mail_from=$from;
        $this->mail_subject=$subject;
        $this->data=$data;
        $this->view_template=$view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail_from_name=Config::get('mail.from.name');

        return $this->view($this->view_template)
            ->from($this->mail_from,$mail_from_name)
            ->subject($this->mail_subject)
            ->with(['data'=>$this->data]);
    }
}
