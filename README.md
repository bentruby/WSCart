# WSCart

This is a basic cart, where a customer can add items with custom names.

Functionality includes:
-Adding Items
-Removing Items
-Changing Item Quantity
-Emptying the entire cart
-Totals section that shows Subtotal, Tax, Shipping, and Grand Total

Some Business rules for the cart:
-All Items are priced at $10/ea
-5% Sales Tax is applied to the subtotal (not including shipping)
-Shipping is a flat rate of $7
-Free shipping for a subtotal of $50 or more

This is meant to be an example of my programming style/skills in a language without any framework help.

To run this cart, you'll need a webserver and php. MySQL is not needed, I chose to store cart data in Sessions. This choice was based on keeping things light and simple. 

Download the code and place it in the web root of your server. You will want to create a virtual host for this application if the server is a shared resource. 

The application can be run by visiting the web root in a web browser. The file to run is index.php, which is the typical default file for php applications. In the web browser, you will simply need to access the ServerName configured in the Virtual Host (Mapped to the server via hosts file if no DNS is configured). If accessing locally, all that is needed is to visit http://localhost:80/ in the browser (changing port if configured differently). 

If there are any questions or issues arise, please contact me directly

Thank You,

Ben
