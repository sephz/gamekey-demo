<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Game"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="title", type="string", maxLength=200, description="Game title", example="Steam"),
 * @OA\Property(property="description", type="text", description="Game description", example="A cross platform gaming system."),
 * @OA\Property(property="created_at", ref="#/components/schemas/BaseModel/properties/created_at"),
 * @OA\Property(property="updated_at", ref="#/components/schemas/BaseModel/properties/updated_at"),
 * @OA\Property(property="deleted_at", ref="#/components/schemas/BaseModel/properties/deleted_at")
 * )
 */

class Game extends Model
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
    public function keys()
    {
        return $this->hasMany(Key::class);
    }

    /**
     * @param int $ticketCounts
     * @return $this
     */
    public function addTickets(int $ticketCounts)
    {
        foreach (range(1, $ticketCounts) as $i) {
            $this->keys()->create([]);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function ticketsRemaining(): int
    {
        return $this->tickets()
            ->available()
            ->count();
    }
}
