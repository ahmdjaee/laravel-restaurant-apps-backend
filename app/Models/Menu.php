<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'stock',
        'image',
        'tags',
        'active',
    ];

    protected $hidden = ['created_at', 'updated_at'];
        
    public function category() 
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
