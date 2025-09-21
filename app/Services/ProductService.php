<?php
namespace App\Services;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
class ProductService
{
    protected $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function addProduct(array $data, ?UploadedFile $image = null)
    {
        $imagePath = $image ? $image->store('products', 'public') : null;
        return $this->productModel::createProduct($data, $imagePath);
    }
}
?>
