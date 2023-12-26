@extends('layouts.master')

@section('title','二手書拍賣平台')

@section('content')
<hr>
<div class="container px-4 px-lg-5 mt-2 mb-4">
    <form action="{{ route('products.search') }}" method="GET" class="d-flex">
        <input type="text" name="query" class="form-control me-2" placeholder="關鍵字搜尋...">
        <button type="submit" class="btn btn-outline-dark">搜尋</button>
    </form>
</div>
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        <a class="navbar-brand" href="#!">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Services</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- Page Content-->
<div class="container px-4 px-lg-5">
    <!-- Heading Row-->
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="https://dummyimage.com/900x400/dee2e6/6c757d.jpg" alt="..." /></div>
        <div class="col-lg-5">
            <h1 class="font-weight-light">Business Name or Tagline</h1>
            <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
            <a class="btn btn-primary" href="#!">Call to Action!</a>
        </div>
    </div>
    <!-- Call to Action-->
    <div class="card text-white bg-secondary my-5 py-4 text-center">
        <div class="card-body"><p class="text-white m-0">This call to action card is a great place to showcase some important information or display a clever tagline!</p></div>
    </div>
    <!-- Content Row-->
    <div class="row gx-4 gx-lg-5">
        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="card-title">Card One</h2>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.</p>
                </div>
                <div class="card-footer"><a class="btn btn-primary btn-sm" href="#!">More Info</a></div>
            </div>
        </div>
        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="card-title">Card Two</h2>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod tenetur ex natus at dolorem enim! Nesciunt pariatur voluptatem sunt quam eaque, vel, non in id dolore voluptates quos eligendi labore.</p>
                </div>
                <div class="card-footer"><a class="btn btn-primary btn-sm" href="#!">More Info</a></div>
            </div>
        </div>
        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="card-title">Card Three</h2>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem magni quas ex numquam, maxime minus quam molestias corporis quod, ea minima accusamus.</p>
                </div>
                <div class="card-footer"><a class="btn btn-primary btn-sm" href="#!">More Info</a></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantitySpans = document.querySelectorAll('.quantity-span');

        quantitySpans.forEach(span => {
            const quantityInput = span.querySelector('.quantity-input');
            const minusButton = span.querySelector('.quantity-minus');
            const plusButton = span.querySelector('.quantity-plus');

            minusButton.addEventListener('click', function(event) {
                event.preventDefault();
                updateQuantity(quantityInput, -1);
            });

            plusButton.addEventListener('click', function(event) {
                event.preventDefault();
                updateQuantity(quantityInput, 1);
            });
        });

        function updateQuantity(input, change) {
            let newValue = parseInt(input.value) + change;
            if (newValue < 1) {
                newValue = 1;
            }
            input.value = newValue;
        }
    });
</script>
@endsection
