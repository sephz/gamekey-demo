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
use Illuminate\Support\Facades\Http;

/**
 * @OA\Post(
 * path="{merchant_callback_url}",
 * summary="Payment notification",
 * description="Payment notification will be sent to this url via POST.",
 * operationId="transactionCallback",
 * tags={"Callbacks"},
 * @OA\Parameter(
 *     name="signature",
 *     description="Signature of json body, generated using hashmac-sha256, with a predefined secret key.",
 *     in="header",
 *     @OA\Schema(
 *             type="string"
 *         )
 *     ),
 * @OA\RequestBody(
 *    required=true,
 *    description="Content of the POST body",
 *    @OA\JsonContent(
 *       required={"transaction_id"},
 *       @OA\Property(property="transaction_id", type="string", example="cae9cb39-2424-4038-a837-f128959823d1"),
 *       @OA\Property(property="key", type="string", example="STEAM1000"),
 *       @OA\Property(property="total_paid", type="int", example="10000"),
 *       @OA\Property(property="commission", type="int", example="500"),
 *       @OA\Property(property="cc_last", type="string", example="1234"),
 *       @OA\Property(property="status", type="string", example="COMPLETED"),
 *       @OA\Property(property="paid_at", type="date", example="2012-12-12 04:04:04")
 *    ),
 * ),
 * @OA\Response(
 *    response=200,
 *    description="Success",
 *    @OA\JsonContent(
 *          @OA\Property(property="status", type="string", example="ok")
 *        )
 *     )
 * )
*/

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
            'status' => $this->transaction->status,
            'paid_at' => $this->transaction->paid_at,
        ];

        $signature = base64_encode(hash_hmac('sha256', json_encode($body), $merchant->secret, true ));

        $response = Http::timeout(5)->withHeaders(['signature' => $signature])->post($merchant->callback_url, $body);

        if ( isset($response['status']) && $response['status'] !== 'ok' ){
            //retry 10 minutes later
            self::dispatch($this->transaction)->delay(now()->addMinutes(10));
        }

    }
}
