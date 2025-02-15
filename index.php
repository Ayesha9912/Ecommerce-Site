<?php
session_start();
include_once('./connect.php');
include_once('./wishlist.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Home</title>
</head>
<style>
    .swiper-home {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .bg-img {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        border: solid 1px red;
        min-height: 500px;
        padding: 4rem 2rem;
        background-image: url('images/imageye___-_home-bg.jpeg');
        background-repeat: no-repeat;
        background-size: cover;
    }

    .home-text {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        color: white;
        gap: 10px;
    }

    .home-text h1 {
        font-size: 3rem;
    }

    .home-text button {
        background-color: #005CBB;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 10px;
    }

    .cat_slider,
    .pro_slider {
        margin: 4rem 2rem;
    }

    .cat_slider .swiper-wrapper {
        height: 250px;
    }

    .cat_slider .swiper-slide {
        background-color: white;
        display: flex;
        border: solid 3px black;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }

    .pro_slider .swiper-slide {
        background-color: white;
        display: flex;
        border: solid 3px black;
        flex-direction: column;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
        height: 400px;
        padding: 1rem;
        position: relative;
        overflow: hidden;
    }

    .pro_slider .swiper-slide img {
        width: 100%;
        height: 230px;
    }

    .pro_slider .swiper-slide p {
        color: red;
    }

    .qty {
        border: solid 2px black;
        width: 40px;
        height: 40px;
        border-radius: 5px;
    }
   .pro_slider .swiper-slide
    .fa-eye,
    .heart {
        position: absolute;
        padding: 0.5rem;
        border: solid 2px black;
        top: 10px;
        border-radius: 5px;
        background-color: white;
        transition: all ease 0.5s;
    }
    .fa-eye {
        left: -30%;
    }
    .fa-heart {
        right: -30%;
    }
    .pro_slider .swiper-slide:hover .fa-eye {
        left: 10px;
    }
    .pro_slider .swiper-slide:hover .fa-heart {
        right: 10px;
    }
</style>

<body>
    <?php include_once('./components/user_header.php') ?>
    <swiper-container class="mySwiper" space-between="30" pagination="true" pagination-clickable="true">
        <swiper-slide>
            <div class="bg-img">
                <img src="images/home-img-1.png" alt="">
                <div class="home-text">
                    <p>Upto 50% off</p>
                    <h1>Ultra SmartPhones</h1>
                    <button>Shop Now</button>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="bg-img">
                <img src="images/home-img-2.png" alt="">
                <div class="home-text">
                    <p>Upto 50% off</p>
                    <h1>Ultra Smart watch</h1>
                    <button>Shop Now</button>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="bg-img">
                <img src="images/home-img-3.png" alt="">
                <div class="home-text">
                    <p>Upto 50% off</p>
                    <h1>Ultra Earphones</h1>
                    <button>Shop Now</button>
                </div>
            </div>
        </swiper-slide>
    </swiper-container>

    <?php
    $category = [
        ['image' => 'images/icon-7.png', 'name' => 'Phones'],
        ['image' => 'images/icon-8.png', 'name' => 'watches'],
        ['image' => 'images/icon-1.png', 'name' => 'Laptops'],
        ['image' => 'images/icon-2.png', 'name' => 'systems'],
    ];
    ?>
    <div class="container">
        <h1 class="text-center mt-5">PRODUCT CATEGORIES</h1>
        <div class="swiper cat_slider">
            <div class="swiper-wrapper">
                <?php
                foreach ($category as $cat) { ?>
                <a class="swiper-slide" href="category.php?category=<?=$cat['name']?>">
                    <div>
                        <img src="<?= $cat['image'] ?>" alt="">
                        <h3><?= $cat['name'] ?></h3>
                    </div>
                </a>
                    <?php
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="container">
    <h1 class="text-center mt-5">FEATURED PRODUCT</h1>
        <div class="swiper pro_slider">
            <div class="swiper-wrapper">
                <?php
                $products = $conn->prepare('SELECT * FROM `products` LIMIT 6');
                $products->execute();
                if ($products->rowCount() > 0) {
                    while ($row = $products->fetch(PDO::FETCH_ASSOC)) { ?>

                        <div class="swiper-slide">
                            <form method="POST">
                                <input type="hidden" name="pid" value="<?=$row['id']?>">
                                <input type="hidden" name="image" value="<?php echo $row['image_01']; ?>">
                                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                                <img src="upload_img/<?php echo $row['image_01']; ?>" alt="images">
                                <h4><?= $row['name'] ?></h4>
                                <div class="d-flex justify-content-between">
                                    <p>$<?= $row['price'] ?>/-</p>
                                    <input type="number" name="qty" class="qty" min="1" max="99" id=""
                                        onkeypress="if(this.value.length == 2) return false;" value="1">
                                </div>
                                <button href="" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                                <a  href="quick_view.php?pid=<?= $row['id']; ?>" class="fas fa-eye text-dark"></a>
                                <button class="fas fa-heart heart" type="submit" name="add_to_wishlist"></button>
                            </form>
                        </div>

                        <?php
                    }
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <?php include_once('./components/user_footer.php')?>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".cat_slider", {
            slidesPerView: 3,
            spaceBetween: 30,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });

        var swiper = new Swiper(".pro_slider", {
            slidesPerView: 4,
            spaceBetween: 30,
            pagination: {

                clickable: true,
            },
        });

    </script>
</body>

</html>