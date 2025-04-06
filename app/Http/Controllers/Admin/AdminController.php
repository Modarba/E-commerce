<?php
namespace App\Http\Controllers\Admin;
use App\Actions\Admin\AddProductAction;
use App\Actions\Admin\DeleteProductAction;
use App\Actions\Admin\ShowProductAction;
use App\Actions\Admin\UpdateProductAction;
use App\Actions\Admin\UpdateStatusOrderAction;
use App\Actions\User\DeleteOrderAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class AdminController extends Controller
{
    protected  $addProduct;
    protected  $deleteProduct;
    protected  $showProduct;
    protected  $updateProduct;
    protected  $updateStatus;
    public function __construct(
        AddProductAction $addFolder,
        DeleteProductAction $deleteFolder,
        ShowProductAction $showProduct,
        UpdateProductAction $updateProduct,
        UpdateStatusOrderAction $updateStatus,
    )
    {
        $this->addProduct = $addFolder;
        $this->deleteProduct = $deleteFolder;
        $this->showProduct = $showProduct;
        $this->updateProduct= $updateProduct;
        $this->updateStatus= $updateStatus;
    }
    public function addProduct(Request $request)
    {
       return $this->addProduct->handle($request->all());
    }
    public function deleteProduct($id)
    {
        return $this->deleteProduct->handle(['id'=>$id]);
    }
    public  function  showProduct()
    {
        return  $this->showProduct->handle([]);
    }
    public function updateProduct(Request $request,$id)
    {
        $data= [
            'id'=>$id,
        'price'=>$request->price,
            ];
        return $this->updateProduct->handle($data);
    }
    public  function  updateStatus(Request $request,$id)
    {
        $data=[
            'id'=>$id,
            'status'=>$request->status,
        ];
        return $this->updateStatus->handle($data);
    }

}
