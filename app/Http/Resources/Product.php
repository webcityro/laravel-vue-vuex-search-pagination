<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource {

	public function toArray($request) {
		return [
			'id' => $this->id,
			'name' => $this->name,
			'price' => $this->price,
			'edit_url' => route('product.edit', $this->id),
			'destroy_url' => route('product.destroy', $this->id),
		];
	}
}
