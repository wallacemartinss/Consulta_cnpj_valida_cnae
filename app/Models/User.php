<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserStatus;
use Spatie\EloquentSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mokhosh\FilamentKanban\Concerns\HasRecentUpdateIndication;

class User extends Authenticatable implements Sortable
{
    use HasFactory, Notifiable, SortableTrait, HasRoles, HasRecentUpdateIndication;

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'document_number',
        'email',
        'status',
        'role',
        'order_column',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
        ];
    }
    public function user_address(): HasOne
    {
        return $this->hasOne(UserAddress::class);
    }
    public function companies(): HasOne
    {
        return $this->HasOne(Company::class) ;
    }

    public static function ignoreTimestamps($should = true)
    {
        if ($should) {
            static::$ignoreTimestampsOn = array_values(array_merge(static::$ignoreTimestampsOn, [static::class]));
        } else {
            static::$ignoreTimestampsOn = array_values(array_diff(static::$ignoreTimestampsOn, [static::class]));
        }
    }
  
}
