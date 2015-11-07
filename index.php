<?php include("cart.php"); ?>

<?php 

$items = array(
    
    0 => array(
        'name'     => 'TEST',
        'qty'      => 1,
    ),
    1 => array(
        'name'     => 'TEST2',
        'qty'      => 3,
    ),   
    2 => array(
        'name'     => 'TEST3',
        'qty'      => 10,
    ),         


);



$cart = new cart( $items ); 


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>WSCart</title>
        <link rel="stylesheet" type="text/css" href="styles.css" media="all" />        
    </head>
    <body>
        <div class="container">
            <div class="cart">
                <div class="page-title">
                    <h1>WSCart</h1>
                </div>
                <div class="add-product">
                    <div class="field-wrapper">
                        <input class="input-text" type="text" id="product_name" name="coupon_code" value="">
                        <div class="button-wrapper">
                            <button type="button" title="Add" class="button" value="Add"><span><span>Add</span></span></button>
                        </div>
                    </div>
                </div>                    
                <form>
                    <table class="cart-table">
                        <colgroup>
                            <col width="1">
                            <col width="1">
                            <col width="1">
                            <col width="1">
                            <col width="1">                        
                        </colgroup>
                        <thead>
                            <tr class="first last">
                                <th class="a-center" rowspan="1">Product</th>
                                <th class="a-center" rowspan="1">Price</th>                            
                                <th class="a-center" rowspan="1">Qty</th>                            
                                <th class="a-center" rowspan="1">Subtotal</th>
                                <th class="a-center" rowspan="1">&nbsp;</th>
                            </tr>                        
                        </thead>
                        <tfoot>
                            <tr class="first last">
                                <td>
                                    <button type="submit" name="update_cart_action" value="empty_cart" title="Empty Cart" class="button btn-empty" id="empty_cart_button"><span><span>Empty Cart</span></span></button>            
                                </td>
                                <td>&nbsp;</td>
                                <td>                                    
                                    <button type="submit" name="update_cart_action" value="update_cart" title="Update Cart" class="button btn-update" id="update_cart_button"><span><span>Update Cart</span></span></button>                                                                        
                                </td>
                                <td colspan="2">
                                    Subtotal: <?php echo $cart->get_subtotal(); ?><br/>
                                    Tax: <?php echo $cart->get_tax(); ?><br/>
                                    Shipping: <?php echo $cart->get_shipping(); ?><br/>
                                    Grand Total: <?php echo $cart->get_total(); ?><br/>
                                </td>                                
                            </tr>                            
                        </tfoot>
                        <tbody>
                            <?php foreach ( $cart->get_items() as $item_key => $item ): ?>
                            <tr class="first odd">
                                <td class="product-cart-info">
                                    <h2 class="product-name"><?= $item['name']; ?></h2>
                                </td>
                                <td class="product-cart-price">
                                    <span class="price">$<?= $item['price']; ?></span>                
                                </td>
                                <td class="product-cart-actions">
                                    <input type="text" pattern="\d*" name="cart[<?= $item_key; ?>][qty]" value="<?= $item['qty']; ?>" size="4" title="Qty" class="input-text qty" maxlength="12">
                                </td>
                                <td class="product-cart-total" data-rwd-label="Subtotal">
                                    <span class="price"><?= $item['subtotal']; ?></span>                            
                                </td>
                                <td class="a-center product-cart-remove last">
                                    <a href="" title="Remove Product" class="btn-remove">Remove Product</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>                           
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </body>
</html>
