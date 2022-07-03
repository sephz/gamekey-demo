<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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
     *       @OA\Property(property="name", type="string", example="Chew Kai Jun"),
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
     *       @OA\Property(property="uuid", type="string", example="cae9cb39-2424-4038-a837-f128959823d1")
     *        )
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="Invalid input response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Invalid card number")
     *        )
     *     )
     * )
     *
     */
    public function store(StoreTransactionRequest $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionRequest  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
