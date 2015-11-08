<?php 

//fire up the session, we are going to use it for cart contents
session_start();

//Include our cart class so we can use it
include("cart.php");

//Pull cart items from the session, if its set
if( ! empty( $_SESSION["cart_items"] ) ) {
    
    $items = $_SESSION['cart_items'];   
     
} else {
    
    $items = array();
}

//Validation error vars. If populated, will show on add product form
$validation_error = null;
$validation_name = null;
   
//Was the form submitted?
if( ! empty( $_POST["update_cart_action"] ) ) {
    
    /**
    * Yay, internet explorer! Just in case, the button text can be formatted to the value
    * 
    * http://stackoverflow.com/a/4171680/294816
    * http://allinthehead.com/retro/330/coping-with-internet-explorers-mishandling-of-buttons
    */
    $update_cart_action =  strtolower(  str_replace( " ", "_", $_POST["update_cart_action"] ) );
    
    //What button was clicked?
    switch( $update_cart_action ) {
        
        case "add_product":
        
            //validate user input, first check if there was any
            if ( ! empty( $_POST['product_name'] ) ) {
                
                //next, only allow numbers and letters
                if ( preg_match('/^[a-z0-9 .\-]+$/i', $_POST['product_name'] ) ) {
                    
                    //If we have gotten here, things should be good. Create the item.
                    //For the sake of this exercise, items are just arrays.
                    $item = array(
                        'name' => $_POST['product_name'],
                        'qty'  => 1,
                    );
                    
                    //Add the product to our items.
                    $items[] = $item;
                    
                } else {
                
                    //The form was posted with an invalid value, let the user know
                    $validation_error = 'Invalid Product Name. Please use only Letters and Numbers';
                    $validation_name = $_POST['product_name'];           
                    
                }
            
            } else {
                
                //The form was posted without a value, let the user know
                $validation_error = 'Please enter a Product Name';
            
            }        
        
        break;  
                
        case "update_cart":
            
            //Double check the post 
            if ( ! empty( $_POST["cart"] ) ) {
                
                //loop the post items 
                foreach ( $_POST["cart"] as $cart_item_key => $cart_item ) {
                    
                    //Double check to be sure item actually exists
                    if ( array_key_exists( $cart_item_key, $items ) ) {
                    
                        //Check for positive qty
                        if ( $cart_item['qty'] > 0 ) {
                            
                            //Update the qty on the item
                            $items[$cart_item_key]["qty"] = $cart_item['qty'];   
                                                     
                        } else {
                            
                            //remove the item if the qty is less than zero
                            unset( $items[$cart_item_key] );
                            
                        }
                        
                    }                        
                    
                }
                
            }
        
        break;
        
        case "empty_cart":
            
            //Clear out the items array
            $items = array();
            
            //Clear our session variable
            unset( $_SESSION['cart_items'] );
                    
        break;
        
    }
    
}

//Was a Remove Product link clicked?
if ( isset( $_GET["remove_item"] ) ) {
        
    //Double check to be sure item actually exists
    if ( array_key_exists( $_GET["remove_item"], $items ) ) {
        
        //Remove the item from the array
        unset( $items[$_GET["remove_item"]] ); 
        
    }
    
}

//Save our items back to the session
$_SESSION['cart_items'] = $items;

//Create our cart object to apply the business logic.
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
                <form action="index.php" method="POST">
                    <div class="add-product">                        
                        <input type="text" id="product_name" name="product_name" placeholder="Product Name" value="<?php echo $validation_name; ?>">
                        <button type="submit" name="update_cart_action" value="add_product" title="Add Product" id="add_product_button">Add Product</button>                                        
                        <span class="validation-error"><?php echo $validation_error; ?></span>
                    </div>
                    
                    <?php if ( $cart->get_items() ): ?>                                        
                    <table class="cart-table">
                        <colgroup>
                            <col width="1">
                            <col width="1">
                            <col width="1">
                            <col width="1">
                            <col width="1">                        
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="a-left" rowspan="1">Product</th>
                                <th class="a-right" rowspan="1">Price</th>                            
                                <th class="a-center" rowspan="1">Qty</th>                            
                                <th class="a-right" rowspan="1">Subtotal</th>
                                <th class="a-center" rowspan="1">&nbsp;</th>
                            </tr>                        
                        </thead>
                        <tfoot>
                            <tr>
                                <td class="a-left">
                                    <button type="submit" name="update_cart_action" value="empty_cart" title="Empty Cart" id="empty_cart_button">Empty Cart</button>            
                                </td>
                                <td>&nbsp;</td>
                                <td class="a-center">                                    
                                    <button type="submit" name="update_cart_action" value="update_cart" title="Update Cart" id="update_cart_button">Update Cart</button>                                                                        
                                </td>
                                <td colspan="2" class="a-center">
                                    <table class="cart-totals">
                                        <tfoot>
                                            <tr>
                                                <td class="a-right bold">Grand Total</td>
                                                <td class="a-right bold"><?php echo '$' . number_format( $cart->get_total(), 2 ); ?></td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                                <td class="a-right">Subtotal</td>
                                                <td class="a-right"><?php echo '$' . number_format( $cart->get_subtotal(), 2 ); ?></td>
                                            </tr>      
                                            <tr>
                                                <td class="a-right">Tax</td>
                                                <td class="a-right"><?php echo '$' . number_format( $cart->get_tax(), 2 ); ?></td>
                                            </tr>  
                                            <tr>
                                                <td class="a-right">Shipping:</td>
                                                <td class="a-right"><?php echo '$' . number_format( $cart->get_shipping(), 2 ); ?></td>
                                            </tr>                                                                                                                            
                                        </tbody>                                    
                                    </table>
                                 </td>                                
                            </tr>                            
                        </tfoot>
                        <tbody>
                            <?php foreach ( $cart->get_items() as $item_key => $item ): ?>
                            <tr>
                                <td class="a-left">
                                    <?= $item['name']; ?>
                                </td>
                                <td class="a-right">
                                    <?php echo '$' . number_format( $item['price'], 2 ); ?>           
                                </td>
                                <td class="a-center">
                                    <input type="text" pattern="\d*" name="cart[<?= $item_key; ?>][qty]" value="<?= $item['qty']; ?>" size="3" title="Qty" class="a-right" maxlength="5">
                                </td>
                                <td class="a-right">
                                    <?php echo '$' . number_format( $item['subtotal'], 2 ); ?>
                                </td>
                                <td class="a-center">                                    
                                    <a href="index.php?remove_item=<?php echo $item_key; ?>" title="Remove Product">Remove</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>                           
                        </tbody>
                    </table>
                    <?php else: ?>
                        <div class="no-items">Your Cart is empty. Use the form above to add a Product.</div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </body>
</html>
