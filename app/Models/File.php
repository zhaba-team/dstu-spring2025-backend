<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use App\Observers\FileObserver;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $storage   Хранилище local, s3 и т.д.
 * @property string $name      Название для отображения
 * @property string $path      Путь к файлу
 * @property string $md5       md5 хэш файла
 * @property string $sha1      sha1 хэш файла
 * @property int $size         Размер файла
 *
 * @property-read string $url
 * @property-read string $cache_booster
 */
#[ObservedBy([FileObserver::class])]
class File extends Model
{
    protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'storage',
        'name',
        'path',
        'md5',
        'sha1',
        'size',
    ];

    /** @return Attribute<string, void> */
    public function url(): Attribute
    {
        return Attribute::make(
            get: fn(): string => Storage::url($this->path) . '?' . $this->cache_booster
        );
    }
    /**
     * Форматы дат
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'date:d.m.Y H:i:s',
            'updated_at' => 'date:d.m.Y H:i:s',
        ];
    }
}
