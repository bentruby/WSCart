<?php

class cart {
    
    /**
    * Declare the structure of the cart
    */    
    private $_items; //Could be cartItem Model, but keeping as an array for now. 
    private $_subtotal;
    private $_tax;
    private $_shipping;
    private $_total;
    
    /**
    * Declare some constants, these are the basis for our business logic
    */
    private $_item_price              = 10;
    private $_tax_rate                = .05;
    private $_shipping_rate           = 7;
    private $_free_shipping_threshold = 50;
    
    /**
    * Build the cart
    */
    function __construct( $items = array() ) {
        
        //Set up our items from input
        $this->_set_items( $items );
        
        //Calculate totals (sub,tax,shipping,total)
        $this->_subtotal = $this->get_subtotal();
        $this->_tax      = $this->get_tax();
        $this->_shipping = $this->get_shipping();
        $this->_total    = $this->get_total();
                                  
    }
    
    /**
    * Return the array of items
    * If there are no items (empty cart), return an empty array to prevent null issues
    */
    public function get_items() {
        
        //if no items exist (empty cart), return an empty array to avoid null issues
        if ( $this->_items == NULL ) {
            
            return array();
            
        }
        
        //if there are items, return them
        return $this->_items;
        
    }
    
    /**
    * Take array of items and add price and subtotal.
    * 
    * expects an array like so:
    * $items = array(
            
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
    * 
    * @param array $items
    */
    private function _set_items( $items ) {
        
        //loop in the passed items, noting the key so we can alter as we loop
        foreach ( $items as $item_key => $item ) {
            
            //Add in price from our defined value
            $items[$item_key]['price']    = $this->_item_price;
            
            //subtotal = price * qty
            $items[$item_key]['subtotal'] = $items[$item_key]['price'] * $item['qty'];
            
        } 
        
        //return our modified array.
        $this->_items = $items;
        
    }
    
    /**
    * Return the subtotal, will calculate if needed
    *    
    */
    public function get_subtotal() {                
    
        // Calculate the subtotal if it needs to be
        if ( $this->_subtotal == NULL ) {
            
            $this->_subtotal = $this->_calc_subtotal();
            
        }        
        
        //return the calculated subtotal
        return $this->_subtotal;
        
    }
    
    /**
    * Calculate cart subtotal based on items in the cart
    * 
    */
    private function _calc_subtotal() {
        
        //Start at zero
        $subtotal = 0;
        
        //Loop items in the cart
        foreach ( $this->get_items() as $item) {
        
            //Increment the subtotal with each item's subtotal
            $subtotal += $item['subtotal']; 
        }  
        
        //return our figure
        return $subtotal;  
        
    }
    
    /**
    * Return the cart's tax amount, calculating if needed
    * 
    */
    public function get_tax() {
        
        //Do we need to calculate tax?
        if ( $this->_tax == NULL ) {
            
            //calculate the tax
            $this->_tax = $this->_calc_tax();   
             
        }               
    
    //return the tax
        return $this->_tax;
        
    }    
    
    /**
    * Calculate cart's tax amount based on subtotal and the defined tax rate
    * 
    * NOTE: Shipping amount is not taxed. 
    * 
    */
    private function _calc_tax() {
        
        //Tax is subtotal * tax rate
        $tax = $this->get_subtotal() * $this->_tax_rate;        
        
        //return our calculation
        return $tax;  
        
    }    
    
    /**
    * return cart's shipping amount, calculate if needed
    * 
    */
    public function get_shipping() {
        
        //find out if we already have a shipping amount or not        
        if ( $this->_shipping == NULL ) {
            
            //Calculate shipping, based on cart items
            $this->_shipping = $this->_calc_shipping();   
             
        }
        
        //return the shipping 
        return $this->_shipping;
        
    }    
    
    /**
    * calculate shipping based on cart items
    * 
    * Free shipping ($0) will be returned if the order subtotal 
    * crosses the free shipping threshold (not including tax!)
    * 
    * Otherwise, flat rate shipping applies
    * 
    */
    private function _calc_shipping() {
        
        //start at zero
        $shipping = 0;
        
        //check if the cart subtotal meets the free shipping threshold.
        if ( count($this->_items) && $this->get_subtotal() < $this->_free_shipping_threshold ) {
            
            //if not, shipping is the flat rate 
            $shipping = $this->_shipping_rate;    
        }
        
        //return the shipping amount
        return $shipping;  
        
    }      
    
    /**
    * get our cart's grand total, calculating if needed
    * 
    */
    public function get_total() {
    
        //find out if we need to calculate the total
        if ( $this->_total == NULL ) {
            
            //calculate the total
            $this->_total = $this->_calc_total();   
             
        }        
        
        //return the total
        return $this->_total;
    }        
    
    /**
    * Calculate the cart total
    * 
    * Total = Subtotal + Tax + Shipping
    * 
    */
    private function _calc_total() {
        
        //Start at zero
        $total = 0;
        
        //add in our total lines
        $total += $this->get_subtotal();
        $total += $this->get_tax();
        $total += $this->get_shipping();
        
        //return the total        
        return $total;
        
    }
        
}
  
?>
