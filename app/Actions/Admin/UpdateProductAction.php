<?php

namespace App\Actions\Admin;

use App\Actions\BaseAction;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class UpdateProductAction extends BaseAction
{
    public function validate(array $data)
    {
        Validator::make($data,[
            'id'=>'required',
            'price' => 'required|numeric'

        ])->validate();
    }
    public function execute(array $data)
    {
        $product = Product::findOrFail($data['id']);
        $product->update(['price' => $data['price']]);
        return $product;
    }
    protected function resource($result) :JsonResource
    {
        return new  ProductResource($result);
    }
}
