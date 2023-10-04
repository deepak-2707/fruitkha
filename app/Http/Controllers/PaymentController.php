<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaymentController extends Controller
{
    public function handlePayment(Request $request)
    {

        $product = Cart::leftJoin('product','product.id','carts.product_id')->where('carts.user_id', '=', \DB::raw('"' . $_COOKIE['user_id'] . '"'))->get();
        $subtotal_price = 0;
        foreach ($product as $key => $value) {
            $subtotal_price += $value->price * $value->qty;
        }
        $shipping = 45; //fixed shipping charge
        $total_price = $subtotal_price + $shipping;

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment'),
                "cancel_url" => route('cancel.payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $total_price
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('checkout')
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('checkout')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function paymentCancel()
    {
        return redirect()
            ->route('checkout')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $this->saveOrder($request['token'], $request['PayerID']);

            return view('success');
        } else {
            return redirect()
                ->route('checkout')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function saveOrder($token, $payerID){
        $product = Cart::leftJoin('product','product.id','carts.product_id')->where('carts.user_id', '=', \DB::raw('"' . $_COOKIE['user_id'] . '"'))->get();
        $subtotal_price = 0;
        foreach ($product as $key => $value) {
            $subtotal_price += $value->price * $value->qty;
        }
        $shipping = 45; //fixed shipping charge
        $total_price = $subtotal_price + $shipping;

        $getAddress = Address::where('user_id',$_COOKIE['user_id'])->orderBy('id','desc')->first();

        $order = new Order();
        $order->user_id = $_COOKIE['user_id'];
        $order->token = $token; 
        $order->payer_id = $payerID; 
        $order->total_price = $total_price; 
        $order->address = $getAddress->address;
        if($order->save()){
            $this->saveOrderDetails($order->id, $product);
        }else{
            $this->saveOrder($token, $payerID);
        }
    }

    public function saveOrderDetails($order_id, $product){
        foreach($product as $item){
            $orderDetail = new OrderDetails();
            $orderDetail->user_id = $_COOKIE['user_id'];
            $orderDetail->order_id = $order_id;
            $orderDetail->product_id = $item->product_id;
            $orderDetail->name = $item->name;
            $orderDetail->qty = $item->qty;
            $orderDetail->price = $item->price;
            $orderDetail->save();
        }
        $this->deleteAllCart();
    }

    public function deleteAllCart(){
        Cart::where('user_id', $_COOKIE['user_id'])->delete();
    }
}
