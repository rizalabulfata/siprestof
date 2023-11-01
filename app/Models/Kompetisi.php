<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kompetisi extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Table's name
     */
    protected $table = 'kompetisi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [];

    protected $guarded = ['id'];

    public function kodifikasi()
    {
        return $this->belongsTo(Kodifikasi::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deleted_at' => 'datetime',
    ];
}
