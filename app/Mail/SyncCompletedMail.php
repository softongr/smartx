<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\SyncBatch;
class SyncCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(SyncBatch $batch)
    {
        $this->batch = $batch;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match ($this->batch->type) {
            'categories' => 'Συγχρονισμός Κατηγοριών Ολοκληρώθηκε',
            'products' => 'Συγχρονισμός Προϊόντων Ολοκληρώθηκε',
            'orders' => 'Συγχρονισμός Παραγγελιών Ολοκληρώθηκε',
            'carriers' =>  'Συγχρονισμός μεταφορικών Ολοκληρώθηκε',
            default => 'Συγχρονισμός Ολοκληρώθηκε',
        };

        return new Envelope(subject: $subject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.sync.completed',
            with: [
                'batch' => $this->batch,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
