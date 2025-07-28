<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Championship extends Model
{
    use HasFactory;

    protected $fillable = ['category_id','avatar','name','status'];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter($query, array $filters){
        
        return $query
                    ->when($filters['name'] ?? false, fn($q, $name) =>
                        $q->where('name','LIKE',"%{$name}%")
                    );
    }
}
