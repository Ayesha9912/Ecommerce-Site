<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['add_to_wishlist'])){
        $user_id = $_SESSION['user_id'];
        $image = $_POST['image'];
        $pid = $_POST['pid'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $already_wishlist = $conn->prepare('SELECT * FROM `wishlist` WHERE name =? AND user_id = ?');
        $already_wishlist->execute([$name, $_SESSION['user_id']]);
        if($already_wishlist->rowCount() > 0){
            $message[] = "Product Already in the wishlist";
        }else{
            $add_wishlist = $conn->prepare('INSERT INTO `wishlist` (user_id, pid, name, price,image) VALUES (?,?,?,?,?)');
            $add_wishlist->execute([$user_id,$pid, $name, $price, $image]);
            $message[] = "Product added to wishlist";
        }
        
    }
// Products Added into Cart
    if(isset($_POST['add_to_cart'])){
        $user_id = $_SESSION['user_id'];
        $image = $_POST['image'];
        $pid = $_POST['pid'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $already_cart = $conn->prepare('SELECT * FROM `cart` WHERE name =?');
        $already_cart->execute([$name]);
        if($already_cart->rowCount() > 0){
            $message[] = "Product Already in the cart";
        }else{
            $add_cart = $conn->prepare('INSERT INTO `cart` (user_id, pid, name, price, quantity , image) VALUES (?,?,?,?,?,?)');
            $add_cart->execute([$user_id,$pid, $name, $price, $qty ,  $image]);
            $message[] = "Product added to cart";
        }
        
    }
}  
 ?>