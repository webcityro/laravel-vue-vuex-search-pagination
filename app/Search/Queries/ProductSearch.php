<?php

namespace App\Search\Queries;

use App\Product;
use Illuminate\Support\Collection;
use App\Search\Queries\EloquentSearch;
use Illuminate\Database\Eloquent\Builder;

class ProductSearch extends Search {

	use EloquentSearch;

	protected function query(): Builder {
	 	return Product::query();
	}

	protected function filter(Builder $query, string $field, string $value): Builder {
		return $query->where($field, 'LIKE', '%'.$value.'%');
	}
}
