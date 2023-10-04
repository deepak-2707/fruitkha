<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    public function __construct(){
        if(!isset($_COOKIE['user_id'])){
            setcookie('user_id', uniqid(), time() + (86400 * 30), "/");
        }
        if(isset($_COOKIE['user_id'])){
            $this->data['cartValue'] = Cart::where('user_id',$_COOKIE['user_id'])->count();
        }
    }

    public function index(){
        $userId = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : uniqid();
       
        if(!isset($_COOKIE['user_id'])){
            setcookie('user_id', $userId, time() + (86400 * 30), "/");
        }

        $this->data['products'] = Product::select('product.*',  \DB::raw('IF(carts.product_id != "", 1, 0) as cart_product'))->leftJoin('carts', function($join) use ($userId) {
            $join->on('carts.product_id', '=', 'product.id')
            ->on('carts.user_id', '=', \DB::raw('"' . $userId . '"') );
        })->limit(3)->get();
        // echo "<pre>"; print_r($this->data['products']); exit;
        return view('index', $this->data);
    }

    public function cart(){
        $this->data['products'] = $product = Cart::leftJoin('product','product.id','carts.product_id')->where('carts.user_id', '=', \DB::raw('"' . $_COOKIE['user_id'] . '"'))->get();
        $this->data['subtotal_price'] = 0;
        foreach ($product as $key => $value) {
            $this->data['subtotal_price'] += $value->price * $value->qty;
        }
        $this->data['shipping'] = 45;
        $this->data['total_price'] = $this->data['subtotal_price'] + $this->data['shipping'];
        return view('cart', $this->data);
    }

    public function updateCart(Request $request){
        foreach($request->product as $key => $value){
            Cart::where(['user_id' => $_COOKIE['user_id'], 'product_id' => $key])->update(['qty' => $value]);
        }
        return redirect()->back()->with('message','Cart updated successfully');
    }

    public function removeFromCartDetails(Request $request){
        $cart = Cart::where(['user_id' => $_COOKIE['user_id'], 'product_id' => $request->product_id])->delete();
        if($cart){
            $message = 'Product removed from cart';
        }else{
            $message = 'Something went wrong';
        }
        $getCartValue = Cart::leftJoin('product','product.id','carts.product_id')->where('carts.user_id', '=', \DB::raw('"' . $_COOKIE['user_id'] . '"'))->get();
        $output = '';
        $subtotal_price = 0;
        foreach($getCartValue as $item){
            $subtotal_price += $item->price * $item->qty;
            $output .= '<tr class="table-body-row">
                            <td class="product-remove"><a onclick="removeFromCartDetails('.$item->product_id.')"><i class="far fa-window-close"></i></a></td>
                            <td class="product-image"><img src="assets/img/products/'.$item->image.'" alt=""></td>
                            <td class="product-name">'.$item->name.'</td>
                            <td class="product-price">$'.$item->price.'</td>
                            <td class="product-quantity"><input type="number" min="1" name="product['.$item->product_id.']" value="'.$item->qty.'"></td>
                            <td class="product-total">$'.$item->qty * $item->price.'</td>
                        </tr>';
        }
        $total_price = $subtotal_price + 45; //shipping charge fixed
        print_r(
            json_encode(
                array(
                    'cartValue' => count($getCartValue),
                    'message' => $message,
                    'tableData' => $output,
                    'subtotal_price' => $subtotal_price,
                    'total_price' => $total_price
                )
            )
        );
        exit;
    }

    public function checkout(){
        $this->data['products'] = $product = Cart::leftJoin('product','product.id','carts.product_id')->where('carts.user_id', '=', \DB::raw('"' . $_COOKIE['user_id'] . '"'))->get();
        $this->data['subtotal_price'] = 0;
        foreach ($product as $key => $value) {
            $this->data['subtotal_price'] += $value->price * $value->qty;
        }
        $this->data['shipping'] = 45; //fixed shipping charge
        $this->data['total_price'] = $this->data['subtotal_price'] + $this->data['shipping'];
        return view('checkout', $this->data);
    }

    public function addToCart(Request $request){
        $cart = new Cart();
        $cart->user_id = $_COOKIE['user_id'];
        $cart->product_id = $request->product_id;
        if($cart->save()){
            $message = 'Product added to cart';
        }else{
            $message = 'Something went wrong';
        }
        
        $getCartValue = Cart::where('user_id',$_COOKIE['user_id'])->count();
        print_r(
            json_encode(
                array(
                    'cartValue' => $getCartValue,
                    'message' => $message 
                )
            )
        );
        exit;
    }

    public function removeFromCart(Request $request){
        $cart = Cart::where(['user_id' => $_COOKIE['user_id'], 'product_id' => $request->product_id])->delete();
        if($cart){
            $message = 'Product removed from cart';
        }else{
            $message = 'Something went wrong';
        }
        $getCartValue = Cart::where('user_id',$_COOKIE['user_id'])->count();
        print_r(
            json_encode(
                array(
                    'cartValue' => $getCartValue,
                    'message' => $message 
                )
            )
        );
        exit;
    }

    public function validatePayment(Request $request){
        $address = new Address();   
        $address->user_id = $_COOKIE['user_id'];
        $address->name = $request->name;
        $address->email = $request->email;
        $address->address = $request->address;
        $address->mobile = $request->mobile;
        $address->message = $request->message;
        if($address->save()){
            $redirect = 'handle-payment';
        }else{
            $redirect = '';
        }
        print_r(
            json_encode(
                array(
                    'redirect' => $redirect 
                )
            )
        );
        exit;
    }

    public function shop(){
        $this->data['products'] = Product::select('product.*',  \DB::raw('IF(carts.product_id != "", 1, 0) as cart_product'))->leftJoin('carts', function($join){
            $join->on('carts.product_id', '=', 'product.id')
            ->on('carts.user_id', '=', \DB::raw('"' . $_COOKIE['user_id'] . '"'));
        })->get();
        // echo "<pre>"; print_r($this->data['products']); exit;
        return view('shop', $this->data);
    }

    public function productDetails($id){
        $this->data['products'] = Product::select('product.*',  \DB::raw('IF(carts.product_id != "", 1, 0) as cart_product'))->leftJoin('carts', function($join){
            $join->on('carts.product_id', '=', 'product.id')
            ->on('carts.user_id', '=', \DB::raw('"' . $_COOKIE['user_id'] . '"'));
        })->where('product.id', $id)->first();
        return view('product-details', $this->data);
    }
}
