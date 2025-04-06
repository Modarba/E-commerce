<?php

namespace App\Actions\User;

use App\Actions\BaseAction;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class SearchAction extends  BaseAction
{
    public function validate(array $data)
    {
        Validator::make($data, [
            'name'=>'required',
        ])->validate();
    }
    public function execute(array $data)
    {
        $product=Product::where('name','like',$data['name'].'%')->get();
        return $product;
    }
    public function resource($result):JsonResource
    {
        return ProductResource::collection($result);

    }
}
