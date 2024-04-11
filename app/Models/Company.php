<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'released',
        'document_number',
        'open_date',
        'fantasy_name',
        'social_reason',
        'company_size',
        'legal_nature',
        'share_capital',
        'status',
        'simei_situation',
        'simple_situation',
        'principal_cnae_description',
        'principal_cnae_code',
        'email',
        'phone',
        'cellphone',
        'especial_situation',
        'registration_situation_reason',
        'registration_situation_reason_data',
    ];
    public function company_address(): HasOne
    {
        return $this->hasOne(CompanyAddress::class);
    }  

    public function secondary_activities(): HasOne
    {
        return $this->HasOne(SecondaryActivitie::class);
    }  

  

}
