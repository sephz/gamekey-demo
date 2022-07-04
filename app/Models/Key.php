<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Key"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="game_id", type="integer", readOnly="true", description="Foreign key of game", example="1"),
 * @OA\Property(property="key", type="string", maxLength=80, description="Game key", example="ASDAS1000"),
 * @OA\Property(property="currency", type="string", maxLength=3, description="Currency",  example="MYR"),
 * @OA\Property(property="price", type="int", description="Price in cents", example="1000"),
 * @OA\Property(property="sold_at", type="string", format="date-time", description="The time when this key was sold."),
 * @OA\Property(property="created_at", ref="#/components/schemas/BaseModel/properties/created_at"),
 * @OA\Property(property="updated_at", ref="#/components/schemas/BaseModel/properties/updated_at"),
 * @OA\Property(property="deleted_at", ref="#/components/schemas/BaseModel/properties/deleted_at")
 * )
 */

class Key extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_price',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo(Game::class, 'games');
    }

    /**
     * @return string
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price / 100, 2);
    }

    public function sold()
    {
        $this->update(['sold_at' => $this->freshTimestamp()]);
    }
}
