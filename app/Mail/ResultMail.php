<?php

namespace App\Mail;

use App\Models\Releasing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class ResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $releasing;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Releasing $releasing)
    {
        $this->releasing = $releasing;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $attachmentPath = storage_path('app/public/' . $this->releasing->result_file);

        if (!Storage::exists('public/' . $this->releasing->result_file)) {
            return $this->subject('Your Test Result')
                ->view('emails.result')
                ->with([
                    'patientName' => $this->releasing->transaction->patient->full_name,
                ]);
        }

        return $this->subject('Your Test Result')
            ->view('emails.result')
            ->attach($attachmentPath, [
                'as' => 'result.pdf',
                'mime' => 'application/pdf',
            ])
            ->with([
                'patientName' => $this->releasing->transaction->patient->full_name,
            ]);
    }
}
