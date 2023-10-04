@include('layout.header')

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>See more Details</p>
                    <h1>{{$products->name}}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- single product -->
<div class="single-product mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="single-product-img">
                    <img src="{{asset('assets/img/products/'.$products->image)}}" alt="">
                </div>
            </div>
            <div class="col-md-7">
                <div class="single-product-content">
                    <h3>{{$products->name}}</h3>
                    <p class="single-product-pricing"><span>Per Kg</span> ${{$products->price}}</p>
                    <p>{{$products->description}}</p>
                    <div class="single-product-form">
                        @if ($products->cart_product == 0)
						<a onclick="addToCart('{{$products->id}}')" class="cart-btn cartBtn{{$products->id}}"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
						@else
						<a onclick="removeFromCart('{{$products->id}}')" class="cart-btn cartBtn{{$products->id}}"><i class="fas fa-times"></i> Remove Cart</a>
						@endif
                        <p><strong>Categories: </strong>Fruits, Organic</p>
                    </div>
                    <h4>Share:</h4>
                    <ul class="product-share">
                        <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href=""><i class="fab fa-twitter"></i></a></li>
                        <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                        <li><a href=""><i class="fab fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end single product -->

@include('layout.footer')