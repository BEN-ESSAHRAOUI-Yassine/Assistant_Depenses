<?php

namespace App\Models;

use App\Enums\StatutRecu;
use Database\Factories\RecuFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recu extends Model
{
    /** @use HasFactory<RecuFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'texte_source',
        'statut',
        'payload_brut',
        'estimated_total',
        'currency',
        'error_message',
    ];

    protected function casts()
    {

        return [
            'statut' => StatutRecu::class,
            'payload_brut' => 'array',
            'estimated_total' => 'decimal:2',

        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function depenses(): HasMany
    {
        return $this->hasMany(Depense::class);
    }
}
