<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'table_id', // tableId
        'time',
        'date',
        'persons',
        'status',
        'notes'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id') ;
    }

    public function table() : BelongsTo
    {
        return $this->belongsTo(Table::class, 'table_id');
    }
}
