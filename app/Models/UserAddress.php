<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'zip_code',
        'street',
        'number',
        'district',
        'city',
        'state',
        'complement',
        'reference',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
