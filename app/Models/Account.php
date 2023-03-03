<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Account extends Model
{
    use HasFactory, Notifiable, Uuid, SoftDeletes;


    /**
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'name',
        'status',
        'timezone',
        'country',
        'preference_id',
        'locale'
    ];
    /**
     * Get user related to the account
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    /**
     * Get related other users of the account and their roles
     * @return HasOne
     */
    public function accountRoleUser()
    {
        return $this->hasOne(AccountRoleUser::class);
    }
}
