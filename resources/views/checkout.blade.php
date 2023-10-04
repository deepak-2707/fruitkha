@include('layout.header')

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Check Out Product</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- check out section -->
<div class="checkout-section mt-150 mb-150">
    <div class="container">
        @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible show" role="alert">
            <strong>Error!</strong> {{Session::get('error')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-accordion-wrap">
                    <div class="accordion" id="accordionExample">
                        <div class="card single-accordion">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Billing Address
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="billing-address-form">
                                        <form action="index.html">
                                            <p>
                                                <input type="text" placeholder="Name" name="name" id="name" required>
                                                <span class="nameErr text-danger"></span>
                                            </p>
                                            <p>
                                                <input type="email" placeholder="Email" name="email" id="email" required>
                                                <span class="emailErr text-danger"></span>
                                            </p>
                                            <p>
                                                <input type="text" placeholder="Address" name="address" id="address" required>
                                                <span class="addressErr text-danger"></span>
                                            </p>
                                            <p>
                                                <input type="tel" placeholder="Phone" name="mobile" id="mobile" required>
                                                <span class="mobileErr text-danger"></span>
                                            </p>
                                            <p>
                                                <textarea name="message" id="message" cols="30" rows="10" placeholder="Say Something"></textarea>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="order-details-wrap">
                    <table class="order-details">
                        <thead>
                            <tr>
                                <th>Your order Details</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody class="order-details-body">
                            <tr>
                                <td>Product</td>
                                <td>Total</td>
                            </tr>
                            @foreach($products as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>${{$item->qty * $item->price}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tbody class="checkout-details">
                            <tr>
                                <td><strong>Subtotal</strong></td>
                                <td><strong>${{$subtotal_price}}</strong></td>
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td>${{$shipping}}</td>
                            </tr>
                            <tr>
                                <td><strong>Total</strong></td>
                                <td><strong>${{$total_price}}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <a onclick="makePayment()" class="boxed-btn">Place Order (<strong>${{$total_price}}</strong>)</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end check out section -->

@include('layout.footer')
