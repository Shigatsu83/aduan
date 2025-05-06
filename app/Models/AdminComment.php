<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'aduan_id',
        'komentar',
        'user_id',
        'status_aduan',
    ];

    /**
     * Mendapatkan aduan yang terkait dengan komentar ini.
     */
    public function aduan()
    {
        return $this->belongsTo(Aduan::class);
    }

    /**
     * Mendapatkan admin yang membuat komentar ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
