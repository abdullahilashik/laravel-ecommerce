<?php

namespace App\Http\DTOs;

use App\Models\Product;

class ProductTabDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly string $url,
        public readonly ?string $categoryName,
        public readonly ?string $categorySlug,
        public readonly ?string $brandName,
        public readonly ?string $image,
        public readonly ?string $hoverImage,
        public readonly float $price,
        public readonly ?float $salePrice,
        public readonly string $badge,
        public readonly float $ratingPercent,
        public readonly float $averageRating,
        public readonly int $reviewCount,
        public readonly string $delay,
    ) {}

    public static function fromModel(Product $model, int $index = 0): self
    {
        $images      = $model->images->sortBy('sort_order')->values();
        $primary     = $model->primaryImage;
        $hover       = $images->first(fn($img) => ! $img->is_primary) ?? $primary;
        $salePrice   = $model->sale_price;
        $average     = (float) $model->reviews->avg('rating');
        $reviewCount = $model->reviews->count();
        $badge       = self::resolveBadge($model, $average);

        $delayIndex = ($index % 5) + 1;

        return new self(
            id:            $model->id,
            name:          $model->name,
            slug:          $model->slug,
            url:           route('product.show', $model->slug),
            categoryName:  $model->category?->name,
            categorySlug:  $model->category?->slug,
            brandName:     $model->brand?->name,
            image:         $primary?->image_path ? asset($primary->image_path) : null,
            hoverImage:    $hover?->image_path ? asset($hover->image_path) : null,
            price:         (float) $model->price,
            salePrice:     $salePrice ? (float) $salePrice : null,
            badge:         $badge,
            ratingPercent: $average * 20,
            averageRating: round($average, 1),
            reviewCount:   $reviewCount,
            delay:         "0.{$delayIndex}s",
        );
    }

    public static function collection($products): array
    {
        return collect($products)
            ->map(fn(Product $product, int $index) => self::fromModel($product, $index))
            ->values()
            ->all();
    }

    public function hasDiscount(): bool
    {
        return $this->salePrice !== null && $this->salePrice < $this->price;
    }

    public function discountPercent(): int
    {
        if (! $this->hasDiscount()) {
            return 0;
        }

        return (int) round((($this->price - $this->salePrice) / $this->price) * 100);
    }

    public function displayPrice(): float
    {
        return $this->salePrice ?? $this->price;
    }

    private static function resolveBadge(Product $model, float $average): string
    {
        if ($model->sale_price && $model->sale_price < $model->price) {
            return 'sale';
        }

        if ($model->is_featured) {
            return 'hot';
        }

        if ($model->created_at->diffInDays(now()) <= 7) {
            return 'new';
        }

        return '';
    }
}
