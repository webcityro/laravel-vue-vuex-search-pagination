<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\SearchRequest;
use App\Search\Queries\ProductSearch;
use App\Http\Requests\SearchFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class FetchRequest extends FormRequest implements SearchFormRequest {

	use SearchRequest;

	public function authorize(): bool {
		return true;
	}

	protected function orderByFields(): array {
		return ['name', 'price'];
	}

	protected function defaultOrderByField(): string {
		return 'name';
	}
}
