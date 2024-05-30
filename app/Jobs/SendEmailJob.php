<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use PDF;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoiceData;
    /**
     * Create a new job instance.
     */
    public function __construct($invoiceData)
    {
        $this->invoiceData = $invoiceData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Here Job called');

        $invoiceData = $this->invoiceData;

        $pdf = PDF::loadView('products.invoice', compact('invoiceData'));

        $emailData["title"] = "Invoice report";
        $emailData["email"] = $invoiceData['email'];

        try {

            \Mail::send('products.invoicemail', $emailData, function ($message) use ($emailData, $pdf) {
                $message->to($emailData["email"])
                    ->subject($emailData["title"])
                    ->attachData($pdf->output(), "invoice.pdf");

            });

            Log::info('Check mail inbox.');

        } catch (\Exception $ex) {

            Log::error('SendEmailJob: ' . $ex->getMessage());

        }

    }
}
