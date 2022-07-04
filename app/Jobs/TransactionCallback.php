<?php

namespace App\Jobs;

use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransactionCallback implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Transaction $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        //
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //get the callback url
        $merchant = $this->transaction->merchant();

        // get key
        $key = $this->transaction->key();

        $body = [
            'transaction_id' => $this->transaction->transaction_id,
            'key' => $key->key,
            'total_paid' => $this->transaction->total_paid,
            'commission' => $this->transaction->commission,
            'cc_last' => $this->transaction->cc_last,
            'paid_at' => $this->transaction->paid_at,
            'status' => $this->transaction->status,
        ];

        $signature = base64_encode(hash_hmac('sha256', json_encode($body), $merchant->secret, true ));

        $response = Http::timeout(5)->withHeaders(['signature' => $signature])->post($merchant->callback_url, $body);

        if ( $response->body() !== 'OK' ){
            //retry 10 minutes later
            self::dispatch($this->transaction)->delay(now()->addMinutes(10));
        }

    }
}
