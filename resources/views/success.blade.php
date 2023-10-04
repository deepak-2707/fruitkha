@include('layout.header')

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Order Placed</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->


<div class="full-height-section error-section" style="height: 45% !importent">
    <div class="full-height-tablecell">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="error-text">
                        <i class="far fa-check-circle"></i>
                        <h1>Success!!</h1>
                        <p>Order Succeessfully Placed.</p>
                        <a href="{{route('home')}}" class="boxed-btn">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('layout.footer')