<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LowStockNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;

    public function __construct(array $emailData)
    {
        $this->emailData = $emailData;
    }

    public function build()
    {
        return $this->subject('Peringatan Stok Minimum')
                    ->view('emails.low_stock_notification')
                    ->with(['data' => $this->emailData]);
    }
}