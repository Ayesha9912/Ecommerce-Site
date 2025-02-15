<?php
session_start();
include_once('./connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - Your eCommerce Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .hero-section {
            background: url('images/imageye___-_home-bg.jpeg') center/cover no-repeat;
            color: white;
            text-align: center;
            padding: 100px 20px;
        }

        .contact-icon {
            font-size: 30px;
            color: #dc3545;
        }
    </style>
</head>

<body>
    <?php include_once('./components/user_header.php') ?>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>Contact Us</h1>
            <p>We're here to help! Get in touch with us.</p>
        </div>
    </section>

    <!-- Contact Information -->
    <div class="container py-5">
        <div class="row text-center">
            <div class="col-md-4">
                <i class="fas fa-map-marker-alt contact-icon"></i>
                <h5 class="mt-3">Our Address</h5>
                <p>123 eCommerce Street, New York, USA</p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-envelope contact-icon"></i>
                <h5 class="mt-3">Email Us</h5>
                <p>support@ecommerce.com</p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-phone contact-icon"></i>
                <h5 class="mt-3">Call Us</h5>
                <p>+1 234 567 890</p>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="container py-5">
        <h2 class="text-center mb-4">Send Us a Message</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="sendmail.php">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea name="message" class="form-control" id="message" rows="4"
                            placeholder="Write your message"></textarea>
                    </div>
                    <button name="submit" type="submit" class="btn btn-danger w-100">Send Message</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Google Map (Optional) -->
    <div class="container-fluid">
        <h2 class="text-center mb-4">Find Us on Google Maps</h2>
        <div class="row">
            <div class="col-12">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345084924!2d144.9537353153185!3d-37.81627974202171!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577dfbd230b82b1!2sMelbourne%2C%20VIC%2C%20Australia!5e0!3m2!1sen!2sus!4v1631804878208!5m2!1sen!2sus"
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
    <?php include_once('./components//user_footer.php') ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var message_text = "<?= $_SESSION['status'] ?? "" ?>";
        if (message_text != "") {
            Swal.fire({
                title: "Thank You",
                text: message_text,
                icon: "success"
            });
            <?php unset($_SESSION['status']) ?>
        }

    </script>
</body>

</html>