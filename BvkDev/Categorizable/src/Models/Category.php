<?php

namespace BvkDev\Categorizable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Kalnoy\Nestedset\NodeTrait;


class Category extends Model
{
    use HasFactory;
    use NodeTrait;

    protected $fillable = ['name', 'slug'];
    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @return mixed
     */
    public function categories(): MorphTo
    {
        return $this->morphTo();
    }


    /**
     * @param string $class
     * @return MorphToMany
     */
    public function entries(string $class): MorphToMany
    {
        return $this->morphedByMany($class, 'model', 'categories_models');
    }

    /**
     * @return array
     */
    public static function tree(): array
    {
        return static::get()->toTree()->toArray();
    }

    /**
     * @return static
     */
    public static function findByName(string $name): self
    {
        return static::where('name', $name)->firstOrFail();
    }

    /**
     * @return static
     */
    public static function findById(int $id): self
    {
        return static::findOrFail($id);
    }


}
