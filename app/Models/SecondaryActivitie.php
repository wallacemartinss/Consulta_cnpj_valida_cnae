<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SecondaryActivitie extends Model
{
    use HasFactory;

    protected $casts = [
        'secondary_activitie' => 'array',
    ];

    protected $fillable = [
        'id',
        'company_id',
        'secondary_activitie',
      
    ];

    public function companies(): BelongsTo
    {
        return $this->BelongsTo(Company::class);
    }  
}
