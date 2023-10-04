<!-- logo carousel -->
<div class="logo-carousel-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="logo-carousel-inner">
                    <div class="single-logo-item">
                        <img src="{{asset('assets/img/company-logos/1.png')}}" alt="">
                    </div>
                    <div class="single-logo-item">
                        <img src="{{asset('assets/img/company-logos/2.png')}}" alt="">
                    </div>
                    <div class="single-logo-item">
                        <img src="{{asset('assets/img/company-logos/3.png')}}" alt="">
                    </div>
                    <div class="single-logo-item">
                        <img src="{{asset('assets/img/company-logos/4.png')}}" alt="">
                    </div>
                    <div class="single-logo-item">
                        <img src="{{asset('assets/img/company-logos/5.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end logo carousel -->

<!-- footer -->
<div class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="footer-box about-widget">
                    <h2 class="widget-title">About us</h2>
                    <p>Ut enim ad minim veniam perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-box get-in-touch">
                    <h2 class="widget-title">Get in Touch</h2>
                    <ul>
                        <li>34/8, East Hukupara, Gifirtok, Sadan.</li>
                        <li>support@fruitkha.com</li>
                        <li>+00 111 222 3333</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-box pages">
                    <h2 class="widget-title">Pages</h2>
                    <ul>
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li><a href="{{route('about')}}">About</a></li>
                        <li><a href="{{route('shop')}}">Shop</a></li>
                        <li><a href="{{route('news')}}">News</a></li>
                        <li><a href="{{route('contact')}}">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-box subscribe">
                    <h2 class="widget-title">Subscribe</h2>
                    <p>Subscribe to our mailing list to get the latest updates.</p>
                    <form action="index.html">
                        <input type="email" placeholder="Email">
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end footer -->

<!-- copyright -->
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <p>Copyrights &copy; 2023 - <a href="https://www.linkedin.com/in/deepak-chandrasen-47874318b/">Deepak Chandrasen</a>,  All Rights Reserved.
                </p>
            </div>
            <div class="col-lg-6 text-right col-md-12">
                <div class="social-icons">
                    <ul>
                        <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="https://www.linkedin.com/in/deepak-chandrasen-47874318b/" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end copyright -->

<!-- jquery -->
<script src="{{asset('assets/js/jquery-1.11.3.min.js')}}"></script>
<!-- bootstrap -->
<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- count down -->
<script src="{{asset('assets/js/jquery.countdown.js')}}"></script>
<!-- isotope -->
<script src="{{asset('assets/js/jquery.isotope-3.0.6.min.js')}}"></script>
<!-- waypoints -->
<script src="{{asset('assets/js/waypoints.js')}}"></script>
<!-- owl carousel -->
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<!-- magnific popup -->
<script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
<!-- mean menu -->
<script src="{{asset('assets/js/jquery.meanmenu.min.js')}}"></script>
<!-- sticker js -->
<script src="{{asset('assets/js/sticker.js')}}"></script>
<!-- main js -->
<script src="{{asset('assets/js/main.js')}}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>

<script>

    function addToCart(product_id){
        $.ajax({
            url: '{{route('addToCart')}}',
            type:"post",
            data: {
            '_token': '{{csrf_token()}}',
            'product_id': product_id
            },
            success: function(response){
                var result = JSON.parse(response)
                $.toast({
                    text: result.message,
                    position: 'top-right',
                    icon: 'success'
                });
                changeOnClickFunction(product_id)
                $('.shopping-cart span').text(result.cartValue)
            }
        })
    }

    function removeFromCart(product_id){
        $.ajax({
            url: '{{route('removeFromCart')}}',
            type:"post",
            data: {
            '_token': '{{csrf_token()}}',
            'product_id': product_id
            },
            success: function(response){
                var result = JSON.parse(response)
                $.toast({
                    text: result.message,
                    position: 'top-right',
                    icon: 'success'
                });
                changeOnClickFunction(product_id)
                if(result.cartValue > 0){
                    $('.shopping-cart span').text(result.cartValue)
                }else{
                    $('.shopping-cart span').text('')
                }
            }
        })
    }
    
    function changeOnClickFunction(product_id) {
        var cartButton = $('.cartBtn'+product_id);

        if (cartButton.attr('onclick') == "addToCart('"+product_id+"')") {
            cartButton.attr('onclick', "removeFromCart("+product_id+")");
            cartButton.html('<i class="fas fa-times"></i> Remove Cart');
        } else {
            cartButton.attr('onclick', "addToCart('"+product_id+"')");
            cartButton.html('<i class="fas fa-shopping-cart"></i> Add to Cart');
        }
    }

    function submitUpdateCartForm(){
        $('#updateCartForm').submit();
    }

    function removeFromCartDetails(product_id){
        $.ajax({
            url: '{{route('removeFromCartDetails')}}',
            type:"post",
            data: {
            '_token': '{{csrf_token()}}',
            'product_id': product_id
            },
            success: function(response){
                var result = JSON.parse(response)
                $.toast({
                    text: result.message,
                    position: 'top-right',
                    icon: 'success'
                });
                if(result.tableData != ''){
                    $('.cart-table tbody').html(result.tableData);
                    $('.subTotal').html('$'+result.subtotal_price);
                    $('.total').html('$'+result.total_price);
                    if(result.cartValue > 0){
                        $('.shopping-cart span').text(result.cartValue)
                    }else{
                        $('.shopping-cart span').text('')
                    }
                }else{
                    window.location.href = '/';
                }
            }
        })
    }

    function makePayment(){
        var nameErr = emailErr = addressErr = mobileErr = '';
        if($('#name').val() == ''){
            nameErr = 'Name is required';
            $('.nameErr').html(nameErr);
        }
        if($('#email').val() == ''){
            emailErr = 'Email is required';
            $('.emailErr').html(emailErr);
        }
        if($('#address').val() == ''){
            addressErr = 'Address is required';
            $('.addressErr').html(addressErr);
        }
        if($('#mobile').val() == ''){
            mobileErr = 'Mobile number is required';
            $('.mobileErr').html(mobileErr);
        }

        if(nameErr == '' && emailErr == '' && addressErr == '' && mobileErr == ''){
            $.ajax({
                url: '{{route('validatePayment')}}',
                type:"post",
                data: {
                '_token': '{{csrf_token()}}',
                'name': $('#name').val(),
                'email': $('#email').val(),
                'address': $('#address').val(),
                'mobile': $('#mobile').val(),
                'message': $('#message').val(),
                },
                success: function(response){
                    var result = JSON.parse(response)
                    if(result.redirect != ''){
                        window.location.href = result.redirect;
                    }else{
                        $.toast({
                            text: 'Something went wrong!! please try again',
                            position: 'top-right',
                            icon: 'warning'
                        });
                    }
                }
            })
        }
    }
</script>


</body>
</html>