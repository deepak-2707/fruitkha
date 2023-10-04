@include('layout.header')

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Cart</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end breadcrumb section -->
<form action="{{route('updateCart')}}" method="post" id="updateCartForm">
    @csrf
    <!-- cart -->
    <div class="cart-section mt-150 mb-150">
        <div class="container">
            @if(Session::has('message'))
            <div class="alert alert-success alert-dismissible show" role="alert">
                <strong>Success!</strong> {{Session::get('message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="cart-table-wrap">
                        <table class="cart-table">
                            <thead class="cart-table-head">
                                <tr class="table-head-row">
                                    <th class="product-remove"></th>
                                    <th class="product-image">Product Image</th>
                                    <th class="product-name">Name</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $item)
                                <tr class="table-body-row">
                                    <td class="product-remove"><a onclick="removeFromCartDetails('{{$item->product_id}}')"><i class="far fa-window-close"></i></a></td>
                                    <td class="product-image"><img src="{{asset('assets/img/products/'.$item->image)}}" alt=""></td>
                                    <td class="product-name">{{$item->name}}</td>
                                    <td class="product-price">${{$item->price}}</td>
                                    <td class="product-quantity"><input type="number" min="1" name="product[{{$item->product_id}}]" value="{{$item->qty}}"></td>
                                    <td class="product-total">${{$item->qty * $item->price}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="total-section">
                        <table class="total-table">
                            <thead class="total-table-head">
                                <tr class="table-total-row">
                                    <th>Total</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            @if(count($products) > 0)
                            <tbody>
                                <tr class="total-data">
                                    <td><strong>Subtotal: </strong></td>
                                    <td class="subTotal">${{$subtotal_price}}</td>
                                </tr>
                                <tr class="total-data">
                                    <td><strong>Shipping: </strong></td>
                                    <td>${{$shipping}}</td>
                                </tr>
                                <tr class="total-data">
                                    <td><strong>Total: </strong></td>
                                    <td class="total">${{$total_price}}</td>
                                </tr>
                            </tbody>
                            @endif
                        </table>
                        @if(count($products) > 0)
                        <div class="cart-buttons">
                            <a onclick="submitUpdateCartForm()" class="boxed-btn">Update Cart</a>
                            <a href="{{route('checkout')}}" class="boxed-btn black">Check Out</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end cart -->
</form>
@include('layout.footer')