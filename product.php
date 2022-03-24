<?php
// include classes
include_once "config/database.php";
include_once "objects/product.php";
include_once "objects/product_image.php";
include_once "objects/cart_item.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
$cart_item = new CartItem($db);
 
// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$action = isset($_GET['action']) ? $_GET['action'] : "";
 
// set the id as product id property
$product->id = $id;
 
// to read single record product
$product->readOne();
 
// set page title
$page_title = $product->name;
 
// include page header HTML
include_once 'layout_head.php';
 
// content will be here
// set product id
$product_image->product_id = $id;
 
// read all related product image
$stmt_product_image = $product_image->readByProductId();
 
// count all relatd product image
$num_product_image = $stmt_product_image->rowCount();
 
echo "<div class='col-md-1'>";
// if count is more than zero
if ($num_product_image > 0) {
 
    // loop through all product images
    while ($row = $stmt_product_image->fetch(PDO::FETCH_ASSOC)) {
 
        // image name and source url
        $product_image_name = $row['name'];
        $source = "uploads/images/{$product_image_name}";
        echo "<img src='{$source}' class='product-img-thumb' data-img-id='{$row['id']}' />";
    }
} else {
    echo "No images.";
}
echo "</div>";
// large image will be here
echo "<div class='col-md-4' id='product-img'>";
 
// read all related product image
$stmt_product_image = $product_image->readByProductId();
$num_product_image = $stmt_product_image->rowCount();
 
// if count is more than zero
if ($num_product_image > 0) {
    // loop through all product images
    $x = 0;
    while ($row = $stmt_product_image->fetch(PDO::FETCH_ASSOC)) {
        // image name and source url
        $product_image_name = $row['name'];
        $source = "uploads/images/{$product_image_name}";
        $show_product_img = $x == 0 ? "display-block" : "display-none";
        echo "<a href='{$source}' target='_blank' id='product-img-{$row['id']}' class='product-img {$show_product_img}'>
                <img src='{$source}' style='width:100%;' />
            </a>";
        $x++;
    }
} else {
    echo "No images.";
}
echo "</div>";
 
// product details will be here

$page_description = htmlspecialchars_decode(htmlspecialchars_decode($product->description));
 
echo "<div class='col-md-5'>
        <h4 class='m-b-10px price-description'>$" . number_format($product->price, 2, '.', ',') . "</h4>
        <div class='m-b-10px'>
            {$page_description}
        </div>
    </div>";
 
// cart buttons will be here
echo "<div class='col-md-2'>";
 
// cart item settings
$cart_item->user_id = 1; // we default to a user with ID "1" for now
$cart_item->product_id = $id;
 
// if product was already added in the cart
if ($cart_item->exists()) {
    echo "<div class='m-b-10px'>This product is already in your cart.</div>
    <a href='cart.php' class='btn btn-success w-100-pct'>
        Update Cart
    </a>";
}
 
// if product was not added to the cart yet
else {
    echo "<a href='add_to_cart.php?id={$id}' class='btn btn-primary w-100-pct'>Add to Cart</a>";
}
 
echo "</div>";

// include page footer HTML
include_once 'layout_foot.php';
?>