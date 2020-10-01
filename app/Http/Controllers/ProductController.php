<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\SearchCollection;
use App\Http\Requests\Product\FetchRequest;
use App\Http\Resources\Product as ProductResource;
use App\Repositories\Contracts\ProductRepositoryContract;

class ProductController extends Controller {

	private $repository;

	public function __construct(ProductRepositoryContract $repository) {
		$this->repository = $repository;
	}

	public function index(): View {
		return view('product.index')
		->with('perPage', new Collection(config('system.per_page')))
		->with('defaultPerPage', config('system.default_per_page'));
	}

	public function fetch(FetchRequest $request): SearchCollection {
		return new SearchCollection(
			$this->repository->search($request), ProductResource::class
		);
	}

	public function edit(Product $product): View {
		return view('product.edit')->with('product', $product);
	}

	public function destroy(Product $product): RedirectResponse {
		$product->delete();
		return new RedirectResponse(route('product'));
	}
}
