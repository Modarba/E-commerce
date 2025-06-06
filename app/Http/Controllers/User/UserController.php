<?php
namespace App\Http\Controllers\User;
use App\Actions\User\BrowseOrderWithProductAction;
use App\Actions\User\DeleteOrderAction;
use App\Actions\User\MakeOrderAction;
use App\Actions\User\PaymentAction;
use App\Actions\User\RemoveProductOrderAction;
use App\Actions\User\SearchAction;
use App\Actions\User\UpdateOrderAction;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function __construct(
        protected SearchAction $searchAction,
        protected MakeOrderAction $makeOrderAction,
        protected PaymentAction $paymentAction,
        protected BrowseOrderWithProductAction $browseOrder,
        protected DeleteOrderAction $deleteOrder,
        protected UpdateOrderAction $updateOrder,
        protected RemoveProductOrderAction $removeProductOrderAction
    ) {
    }

    public function searchProduct(Request $request)
    {
        return $this->searchAction->handle($request->all());
    }
    public function makeOrder(Request $request)
    {
        return $this->makeOrderAction->handle($request->all());
    }
    public function payment(Request $request)
    {
        return $this->paymentAction->handle($request->all());
    }
    public function orderForUser()
    {
        return $this->browseOrder->handle([]);
    }
    public function cancelOrder($id)
    {
        return $this->deleteOrder->handle(['id'=>$id]);
    }
    public  function  updateProductOrder(Request $request, $id)
    {
        $data=[
            'id'=>$id,
            'quantity'=>$request->quantity,
        ];
        return $this->updateOrder->handle($data);
    }
    public function removeProductOrder($id)
    {
        $data=[
            'id'=>$id,
        ];
        return $this->removeProductOrderAction->handle($data);
    }
}
