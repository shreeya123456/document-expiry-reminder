<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;

class SendDocumentExpiryReminders extends Command
{
    protected $signature = 'documents:send-reminders';

    protected $description = 'Check documents and send expiry reminders';

    public function handle()
    {
        $this->info('Checking document expiry dates...');

        $reminderDays = [30, 15, 7];

        foreach ($reminderDays as $days) {

            $expiryDate = now()->addDays($days)->toDateString();

            $documents = Document::whereDate('expiry_date', $expiryDate)->get();

            foreach ($documents as $document) {

                $this->info(
                    $document->document_name .
                    ' expires in ' . $days . ' days.'
                );
            }
        }

        $this->info('Reminder check completed.');

        return self::SUCCESS;
    }
}