<?php

namespace App\Models;

use App\Helpers\StringHelper;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    protected $fillable = [
        'tiket',
        'judul',
        'isi',
        'jenis',
        'lokasi',
        'lampiran',
        'status',
        'is_public',
    ];

    public function adminComments()
    {
        return $this->hasMany(AdminComment::class);
    }

    public function latestComments(){
        return $this->hasOne(AdminComment::class)->latest();
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model){
            $model->tiket = self::generateTicket();
        });
    }
    
    private static function generateTicket(){
        $prefix = strtoupper(Str::random(4));
        $date = now()->format("ymd");
        $suffix = rand(1000, 9999);

        return $prefix . $date . $suffix;
    }
    
    // Konstanta untuk jenis aduan
    public const JENIS_INFRASTRUKTUR = 'Infrastruktur';
    public const JENIS_LINGKUNGAN = 'Lingkungan';
    public const JENIS_PELAYANAN = 'Pelayanan Publik';
    public const JENIS_KEAMANAN = 'Keamanan';
    public const JENIS_LAINNYA = 'Lainnya';
    
    public static function getJenisOptions()
    {
        return [
            self::JENIS_INFRASTRUKTUR => 'Infrastruktur',
            self::JENIS_LINGKUNGAN => 'Lingkungan',
            self::JENIS_PELAYANAN => 'Pelayanan Publik',
            self::JENIS_KEAMANAN => 'Keamanan',
            self::JENIS_LAINNYA => 'Lainnya',
        ];
    }
    
    /**
     * Get the formatted judul.
     *
     * @return string
     */
}
