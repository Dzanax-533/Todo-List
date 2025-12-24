<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public static function findOrCreateByName(string $name)
    {
        $name = trim($name);
        $slug = \Illuminate\Support\Str::slug($name);

        return static::firstOrCreate(
            ['slug' => $slug],
            ['name' => $name, 'slug' => $slug]
        );
    }
}
