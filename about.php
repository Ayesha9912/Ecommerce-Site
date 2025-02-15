<?php
session_start();
include_once('./connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - Your eCommerce Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .hero-section {
            background: url('images/imageye___-_home-bg.jpeg') center/cover no-repeat;
            color: white;
            text-align: center;
            padding: 100px 20px;
        }
        .feature-icon {
            font-size: 40px;
            color: #dc3545;
        }
        .team-member img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body>
<?php include_once('./components/user_header.php') ?>
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1>About Us</h1>
        <p>Your trusted eCommerce store for quality products at unbeatable prices.</p>
    </div>
</section>

<!-- About Content -->
<div class="container py-5">
    <div class="row text-center">
        <div class="col-md-4">
            <i class="fas fa-bullseye feature-icon"></i>
            <h3 class="mt-3">Our Mission</h3>
            <p>We aim to provide high-quality products with an exceptional shopping experience.</p>
        </div>
        <div class="col-md-4">
            <i class="fas fa-star feature-icon"></i>
            <h3 class="mt-3">Our Values</h3>
            <p>Customer satisfaction, affordability, and trust are at the core of our business.</p>
        </div>
        <div class="col-md-4">
            <i class="fas fa-handshake feature-icon"></i>
            <h3 class="mt-3">Customer First</h3>
            <p>We prioritize our customers, ensuring seamless service and fast delivery.</p>
        </div>
    </div>
</div>

<!-- Team Section (Optional) -->
<div class="container py-5">
    <h2 class="text-center">Meet Our Team</h2>
    <div class="row text-center mt-4">
        <div class="col-md-3 col-sm-6 team-member">
            <img src="./images/pic-1.png" alt="Team Member">
            <h5>John Doe</h5>
            <p>Founder & CEO</p>
        </div>
        <div class="col-md-3 col-sm-6 team-member">
            <img src="./images/pic-2.png" alt="Team Member">
            <h5>Sarah Lee</h5>
            <p>Marketing Head</p>
        </div>
        <div class="col-md-3 col-sm-6 team-member">
            <img src="./images/pic-3.png" alt="Team Member">
            <h5>Michael Smith</h5>
            <p>Lead Developer</p>
        </div>
        <div class="col-md-3 col-sm-6 team-member">
            <img src="./images/pic-4.png" alt="Team Member">
            <h5>Emily Brown</h5>
            <p>Customer Support</p>
        </div>
    </div>
</div>

<!-- Call to Action -->
<section class="bg-danger text-white text-center py-4 mb-5">
    <h3>Join Thousands of Happy Shoppers!</h3>
    <p>Experience the best shopping with us.</p>
    <a href="shop.html" class="btn btn-light mt-2 mb-5">Start Shopping</a>
</section>

<?php  include_once('./components/user_footer.php')?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
