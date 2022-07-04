<?php

namespace App\Http\Controllers;

use App\Jobs\TransactionCallback;
use App\Mail\OrderConfirmationEmail;
use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TransactionController extends Controller
{

    /**
     * @OA\Post(
     * path="/v1/transaction/create",
     * summary="Create a payment transaction",
     * description="Create a payment transaction, if it is successful, callback will be sent to merchant",
     * operationId="transactionCreate",
     * tags={"Transactions"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Submit game key selection and card number",
     *    @OA\JsonContent(
     *       required={"name", "key_id", "cc_number", "cvc", "expiry"},
     *       @OA\Property(property="cc_name", type="string", example="Chew Kai Jun"),
     *       @OA\Property(property="key_id", type="integer", example="10"),
     *       @OA\Property(property="cc_number", type="string", example="4242424242424242"),
     *       @OA\Property(property="cvc", type="string", example="123"),
     *       @OA\Property(property="expiry", type="string", example="05-2025"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string", example="Success"),
     *       @OA\Property(property="transaction_id", type="string", example="cae9cb39-2424-4038-a837-f128959823d1")
     *        )
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="Invalid Key ID",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Invalid Key Id")
     *        )
     *     )
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Validation Failed",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Invalid card number")
     *        )
     *     )
     * )
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:10',
            'key_id' => 'required',
            'cc_number' => 'required|luhn|min:15|min:16',
            'cvc' => 'required|min:3|max:4',
            'expiry' => 'required',
        ]);

        // get key details
        $key = Key::find($request->input('key_id'));

        if ( $key === null || $key->sold_at ){
            return response()->json(['message' => 'Invalid Key ID'], 400);
        }

        $merchant_id = $key->game->mercant_id;

        $buyer = Auth::user();

        $commission_rate = config('app.commission_rate');

        $transaction_id = (string) Str::uuid();

        try{

            $transaction = Transaction::create([
                'transaction_id' => $transaction_id,
                'key_id' => $key->id,
                'key' => $key->key,
                'merchant_id' => $merchant_id,
                'buyer_id' => $buyer->id,
                'total_paid' => $key->price,
                'commission' => $key->price * $commission_rate,
                'cc_last' => substr($request->input('cc_number'), -4),
                'status' => 'COMPLETED',
                'paid_at' => Date::now(),
            ]);

            Mail::to($buyer->email)
                ->send(new OrderConfirmationEmail($transaction));

            //callback
            TransactionCallback::dispatch($transaction);

        }catch (\Exception $exception){
            return response()->json(['message' => 'Payment Failed'], 400);
        }

        return response()->json(['success' => true,
            'message' => 'Success, please check your email for the key.',
            'transaction_id' => $transaction_id
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

}
