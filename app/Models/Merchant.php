<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Merchant"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="user_id", type="integer", readOnly="true", description="Foreign key of user", example="1"),
 * @OA\Property(property="name", type="string", maxLength=100, description="Name of seller", example="BlackStone Pte. ltd."),
 * @OA\Property(property="callback_url", type="string", maxLength=150, description="A POST url to receive payment notification", example="https://api.xsolla.com/payment"),
 * @OA\Property(property="secret", type="string", readOnly="true", description="Secret for message signature", example="E47WUt2ZQncDPZKjebqNzca26Jgsh3YV"),
 * @OA\Property(property="active", type="boolean", description="If this merchant account is active"),
 * @OA\Property(property="created_at", ref="#/components/schemas/BaseModel/properties/created_at"),
 * @OA\Property(property="updated_at", ref="#/components/schemas/BaseModel/properties/updated_at"),
 * @OA\Property(property="deleted_at", ref="#/components/schemas/BaseModel/properties/deleted_at")
 * )
 */

class Merchant extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function games()
    {
        return $this->hasMany(Game::class);
    }

}
