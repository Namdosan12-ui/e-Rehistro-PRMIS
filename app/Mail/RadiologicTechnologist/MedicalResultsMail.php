<?php
namespace App\Mail\RadiologicTechnologist;

use App\Models\Releasing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class MedicalResultsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        protected Releasing $releasing
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                Config::get('mail.from.address'),
                Config::get('mail.from.name')
            ),
            subject: $this->getSubjectLine(),
            tags: ['medical-results', 'radiologic-technologist', 'patient-' . $this->releasing->transaction->patient_id],
            metadata: [
                'releasing_id' => $this->releasing->id,
                'transaction_id' => $this->releasing->transaction_id,
                'sent_by' => 'radiologic-technologist'
            ]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'radiologictechnologist.emails.medical-results',
            with: [
                'patientName' => $this->releasing->transaction->patient->first_name . ' ' .
                $this->releasing->transaction->patient->last_name,
                'transactionId' => $this->releasing->transaction_id,
                'testDate' => $this->releasing->transaction->created_at->format('F j, Y'),
                'hospitalName' => Config::get('app.name'),
                'receptionName' => auth()->user()->name
            ]
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromStorage($this->releasing->result_file)
                ->as($this->getFileName())
                ->withMime('application/pdf')
        ];
    }

    private function getSubjectLine(): string
    {
        return sprintf(
            'Medical Results - %s [Ref: %s]',
            Config::get('app.name'),
            $this->releasing->transaction_id
        );
    }

    private function getFileName(): string
    {
        return sprintf(
            'medical-results-%s-%s.pdf',
            $this->releasing->transaction_id,
            now()->format('Y-m-d')
        );
    }
}
