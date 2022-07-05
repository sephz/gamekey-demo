<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Transaction"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="transaction_id", type="uuid", description="Payment Reference", example="cae9cb39-2424-4038-a837-f128959823d1"),
 * @OA\Property(property="key_id", type="integer", readOnly="true", description="Foreign key of key", example="1"),
 * @OA\Property(property="key", type="string", description="Key code", example="ABC100028959823d1"),
 * @OA\Property(property="merchant_id", type="integer", readOnly="true", description="Foreign key of merchant", example="1"),
 * @OA\Property(property="buyer_id", type="integer", readOnly="true", description="Foreign key of user",  example="1"),
 * @OA\Property(property="currency", type="string", maxLength=3, description="Currency",  example="MYR"),
 * @OA\Property(property="total_paid", type="integer", description="Total Paid in cents", example="1000"),
 * @OA\Property(property="commission", type="integer", description="Commission in cents", example="50"),
 * @OA\Property(property="cc_last", type="string", maxLength=4, description="Last four digits of credit card number", example="1234"),
 * @OA\Property(property="status", type="string", maxLength=25, description="Payment Status", example="COMPLETED"),
 * @OA\Property(property="paid_at", type="string", format="date-time"),
 * @OA\Property(property="created_at", ref="#/components/schemas/BaseModel/properties/created_at"),
 * @OA\Property(property="updated_at", ref="#/components/schemas/BaseModel/properties/updated_at"),
 * )
 */

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchants');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function key()
    {
        return $this->hasOne(Key::class, 'keys');
    }
}
