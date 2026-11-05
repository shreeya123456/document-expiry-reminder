<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;
use App\Mail\DocumentExpiryReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class SendDocumentExpiryReminders extends Command
{
    protected $signature = 'documents:send-reminders';

    protected $description = 'Send document expiry reminders';

    public function handle()
    {
        $this->info('Checking document expiry dates...');

        $reminderDays = [30, 15, 7];

        foreach ($reminderDays as $days) {

            $expiryDate = now()->addDays($days)->toDateString();

            $documents = Document::with('user')
                ->whereDate('expiry_date', $expiryDate)
                ->get();

            foreach ($documents as $document) {

                $alreadySent = DB::table('document_reminders')
                    ->where('document_id', $document->id)
                    ->where('days_before', $days)
                    ->exists();

                if ($alreadySent) {
                    continue;
                }

                if (!$document->user || !$document->user->email) {
                    continue;
                }

                Mail::to($document->user->email)
                    ->send(new DocumentExpiryReminder($document, $days));

                DB::table('document_reminders')->insert([
                    'document_id' => $document->id,
                    'days_before' => $days,
                    'sent_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->info(
                    $document->document_name .
                    ' reminder prepared for ' . $days . ' days.'
                );
            }
        }

        $this->info('Reminder check completed.');

        return self::SUCCESS;
    }
}