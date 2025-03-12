<?php
// app/Models/Releasing.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Releasing extends Model
{
    protected $fillable = [
        'transaction_id',
        'result_file',
        'released_at',
        'released_via_email',
        'releasing_status'
    ];

    protected $casts = [
        'released_at' => 'datetime',
        'released_via_email' => 'boolean'
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function markAsReleased(): void
    {
        $this->update([
            'released_at' => now(),
            'released_via_email' => true,
            'releasing_status' => 'released'
        ]);
    }
}
