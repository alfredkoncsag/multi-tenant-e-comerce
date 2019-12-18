<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Contracts\Product as ProductContract;

class Product extends Model implements ProductContract
{
    protected $fillable = ['type', 'attribute_family_id', 'sku', 'parent_id'];
}
