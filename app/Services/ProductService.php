<?php
namespace App\Services;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
class ProductService
{

    public function __construct(
         protected  Product $productModel
    )
    {
    }

    public function addProduct(array $data, ?UploadedFile $image = null)
    {
        $imagePath = $image ? $image->store('products', 'public') : null;
        return $this->productModel::createProduct($data, $imagePath);
    }
}
