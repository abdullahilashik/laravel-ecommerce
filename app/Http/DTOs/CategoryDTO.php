<?php
namespace App\Http\DTOs;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CategoryDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $parent_id,
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $description,
        public readonly ?string $image,
        public readonly int $sort_order,
        public readonly bool $is_active,
        public readonly ?Carbon $deleted_at,
        public readonly Carbon $created_at,
        public readonly Carbon $updated_at,
        public readonly int $products_count = 0
    ) {}

    /**
     * Create a DTO from an array (e.g., from a database query or API response).
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            parent_id: $data['parent_id'] ?? null,
            name: $data['name'],
            slug: $data['slug'],
            description: $data['description'] ?? null,
            image: $data['image']? Storage::url($data['image']) : null,
            sort_order: $data['sort_order'] ?? 0,
            is_active: (bool) ($data['is_active'] ?? true),
            deleted_at: isset($data['deleted_at']) ? Carbon::parse($data['deleted_at']) : null,
            created_at: Carbon::parse($data['created_at']),
            updated_at: Carbon::parse($data['updated_at']),
            products_count: $data['products_count'] ?? 0,
        );
    }

    /**
     * Create a DTO from an Eloquent model.
     */
    public static function fromModel(Model $model): self
    {
        return self::fromArray($model->toArray());
    }

    /**
     * Convert the DTO to an array (useful for API responses).
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
            'deleted_at' => $this->deleted_at?->toDateTimeString(),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'products_count' => $this->products_count,
        ];
    }
}
