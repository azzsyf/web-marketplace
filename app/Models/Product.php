<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'category',
        'description',
        'price',
        'discount_price',
        'image',
        'is_active',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'sizes' => 'array',
            'colors' => 'array',
            'price' => 'decimal:2',
            'discount_price' => 'decimal:2',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: function ($value): array {
                if (is_array($value)) {
                    return array_values(array_filter($value));
                }

                if ($value === null || $value === '') {
                    return [];
                }

                $decoded = json_decode((string) $value, true);

                if (is_array($decoded)) {
                    return array_values(array_filter($decoded));
                }

                return [(string) $value];
            },
            set: fn ($value) => json_encode(
                array_values(array_filter((array) $value)),
                JSON_UNESCAPED_SLASHES
            ),
        );
    }

    protected function primaryImage(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->image[0] ?? null);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getTotalStockAttribute(): int
    {
        if ($this->relationLoaded('variants')) {
            return (int) $this->variants->sum('stock');
        }

        return (int) $this->variants()->sum('stock');
    }

    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'produk';
        $slug = $base;
        $number = 1;

        while (
            static::query()
            ->where('slug', $slug)
            ->when(
                $ignoreId !== null,
                fn($query) => $query->where('id', '!=', $ignoreId)
            )
            ->exists()
        ) {
            $slug = $base . '-' . $number++;
        }

        return $slug;
    }
}
