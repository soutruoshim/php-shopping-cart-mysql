<?php
// connect to database
include 'config/database.php';
 
// include objects
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
 
// set page title
$page_title="Cart";
 
// include page header html
include 'layout_head.php';

$action = isset($_GET['action']) ? $_GET['action'] : "";
 
echo "<div class='col-md-12'>";
if ($action == 'removed') {
    echo "<div class='alert alert-info'>
            Product was removed from your cart!
        </div>";
} else if ($action == 'added') {
    echo "<div class='alert alert-info'>
            Product was added to cart!
        </div>";
} else if ($action == 'quantity_updated') {
    echo "<div class='alert alert-info'>
            Product quantity was updated!
        </div>";
} else if ($action == 'exists') {
    echo "<div class='alert alert-info'>
            Product already exists in your cart!
        </div>";
} else if ($action == 'cart_emptied') {
    echo "<div class='alert alert-info'>
            Cart was emptied.
        </div>";
} else if ($action == 'updated') {
    echo "<div class='alert alert-info'>
            Quantity was updated.
        </div>";
} else if ($action == 'unable_to_update') {
    echo "<div class='alert alert-danger'>
            Unable to update quantity.
        </div>";
}
echo "</div>";
 
// contents will be here 
 // $cart_count variable is initialized in navigation.php
if ($cart_count > 0) {
 
    $cart_item->user_id = "1";
    $stmt = $cart_item->read();
 
    $total = 0;
    $item_count = 0;
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
 
        $sub_total = $price * $quantity;
 
        echo "<div class='cart-row'>
            <div class='col-md-8'>";
 
        // product name
        echo "<div class='product-name m-b-10px'>
                    <h4>{$name}</h4>
                </div>";
 
        // update quantity
        echo "<form class='update-quantity-form'>
                    <div class='product-id' style='display:none;'>{$id}</div>
                    <div class='input-group'>
                        <input type='number' name='quantity' value='{$quantity}' class='form-control cart-quantity' min='1' />
                            <span class='input-group-btn'>
                            <button class='btn btn-default update-quantity' type='submit'>Update</button>
                            </span>
                    </div>
                </form>";
 
        // delete from cart
        echo "<a href='remove_from_cart.php?id={$id}' class='btn btn-default'>
                    Delete
                </a>
            </div>
 
            <div class='col-md-4'>
                <h4>$" . number_format($price, 2, '.', ',') . "</h4>
            </div>
        </div>";
 
        $item_count += $quantity;
        $total += $sub_total;
    }
 
    echo "<div class='col-md-8'></div>
    <div class='col-md-4'>
        <div class='cart-row'>
            <h4 class='m-b-10px'>Total ({$item_count} items)</h4>
            <h4>$" . number_format($total, 2, '.', ',') . "</h4>
            <a href='checkout.php' class='btn btn-success m-b-10px'>
                <span class='glyphicon glyphicon-shopping-cart'></span> Proceed to Checkout
            </a>
        </div>
    </div>";
} else {
    echo "<div class='col-md-12'>
        <div class='alert alert-danger'>
            No products found in your cart!
        </div>
    </div>";
}
// layout footer
include 'layout_foot.php';
?>