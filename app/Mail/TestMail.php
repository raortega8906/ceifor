<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $data;

    public function __construct($data)
    {
        $this->data = $data;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {

        $subject = $request->input('subject');
        
        if($request->hasFile('attachment')) {

            $attach = $request->file('attachment');
            $size = $attach->getSize();

            if($size < 2000000) {

                return $this->subject($subject)
                            ->view('message')
                            ->attach($this->data['attachment']->getRealPath(),
                            [
                                'as' => $this->data['attachment']->getClientOriginalName(),
                                'mime' => $this->data['attachment']->getClientMimeType()
                            ]);
            }
            else {
                return view('mail.compose');

            }
        }
        else {
            return $this->subject($subject)
                        ->view('message');

        }
    }
}
