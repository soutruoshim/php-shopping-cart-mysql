</div>
        <!-- /row -->
 
    </div>
    <!-- /container -->
 
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
 
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
<!-- custom script will be here -->
 
</body>
</html>
<script>
    $(document).ready(function() {
        // update quantity button listener
        $('.update-quantity-form').on('submit', function() {
 
            // get basic information for updating the cart
            var id = $(this).find('.product-id').text();
            var quantity = $(this).find('.cart-quantity').val();
 
            // redirect to update_quantity.php, with parameter values to process the request
            window.location.href = "update_quantity.php?id=" + id + "&quantity=" + quantity;
            return false;
        });
 
        // image hover js will be here
    });
    // change product image on hover
    $(document).on('mouseenter', '.product-img-thumb', function () {
        var data_img_id = $(this).attr('data-img-id');
        $('.product-img').hide();
        $('#product-img-' + data_img_id).show();
    });
</script>