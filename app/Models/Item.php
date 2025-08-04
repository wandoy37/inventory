<?php

namespace App\Models;

use App\Models\ItemUnitType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $fillable = [
        'code',
        'name',
        'description'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function units(): HasMany
    {
        return $this->hasMany(ItemUnitType::class, 'item_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            // Ambil 2 huruf awal nama
            $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $item->name), 0, 2));

            // Ambil ID terakhir dan random 2 digit
            $lastId = self::max('id') ?? 0;
            $nextId = $lastId + 1;
            $random = random_int(10, 99);

            $code = $prefix . str_pad($nextId, 2, '0', STR_PAD_LEFT) . $random;

            // Pastikan kode unik
            while (self::where('code', $code)->exists()) {
                $random = random_int(10, 99);
                $code = $prefix . str_pad($nextId, 2, '0', STR_PAD_LEFT) . $random;
            }

            $item->code = $code;
        });
    }
}
