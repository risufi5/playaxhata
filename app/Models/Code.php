<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Code extends Model
{
    use HasFactory;

    protected $table = 'codes';
    protected $fillable = [
        'value',
        'start_used',
        'finish_used',
        'start_used_date',
        'finish_used_date',
        'score',
        'video_url',
        'user_id',
    ];

    /**
     * Get the user that owns the code.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateUniqueCode()
    {
        do {
            $code = self::generateAlphanumericString(6);
        } while (self::where('value', $code)->exists());

        return $code;
    }

    public static function createUniqueCode()
    {
        $code = self::generateUniqueCode();
        return self::create(['value' => $code]);
    }

    private static function generateAlphanumericString($length = 6): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
