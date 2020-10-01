<?php

namespace App\Http\Requests;

use App\Search\OrderBy;
use App\Search\Params;
use Illuminate\Validation\Rule;
use App\Search\Payloads\Payload;
use App\Search\Payloads\SearchOnlyPayload;

trait SearchRequest {

	public function rules(): array {
		return array_merge([
			'page' => 'required|integer',
			'order_by' => 'required|string',
			'per_page' => [
				'required',
				Rule::in(config('system.per_page'))
			],
			'order_field' => [
				Rule::in($this->orderByFields())
			],
			'order_direction' => [
				Rule::in(['asc', 'desc'])
			]
			], $this->searchParams());
	}

	protected function searchParams(): array {
		return [
			'search' => 'present',
		];
	}

	abstract protected function orderByFields(): array;

	abstract protected function defaultOrderByField(): string;

	protected function defaultOrderByDirection(): string {
		return 'asc';
	}

	protected function prepareForValidation(): void	{
		$this->order_by = $this->order_by ??
			$this->defaultOrderByField().':'.$this->defaultOrderByDirection();

		[$order, $direction] = explode(':', $this->order_by);

		$this->offsetSet('order_field', $order);
		$this->offsetSet('order_direction', $direction);

		$this->per_page = (int)($this->per_page ?? config('system.default_per_page'));
		$this->page = (int)($this->page ?? 1);
	}

	public function requestParams(): Params {
		return new Params($this->payload(), $this->per_page, $this->page, $this->order_by);
	}

	protected function payload(): Payload {
		return new SearchOnlyPayload($this->search ?? null);
	}

	public function requestOrder(): OrderBy {
		return new OrderBy($this->order_field, $this->order_direction);
	}
}
