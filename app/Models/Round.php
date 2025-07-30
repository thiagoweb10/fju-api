<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = ['championship_id', 'round_number', 'date_round', 'status_rounds_id'];

    public function championship()
    {
        return $this->hasMany(Championship::class);
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
                    ->when($filters['round_number'] ?? false, fn ($q, $round_number) => $q->where('round_number', $round_number)
                    );
    }
}
