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
    public function __construct(
        protected AddProductAction $addProduct,
        protected DeleteProductAction $deleteProduct,
        protected ShowProductAction $showProduct,
        protected UpdateProductAction $updateProduct,
        protected UpdateStatusOrderAction $updateStatus
    ) {
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
