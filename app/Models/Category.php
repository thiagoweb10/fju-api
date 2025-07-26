<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','status'];

    public function championship(){
        return $this->hasMany(Championship::class);
    }

    public function scopeFilter($query, array $filters){
        
        return $query
                    ->when($filters['name'] ?? false, fn($q, $name) =>
                        $q->where('name','LIKE',"%{$name}%")
                    );
    }
}