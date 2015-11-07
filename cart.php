<?php

class cart {
    
    /**
    * Declare the structure of the cart
    */    
    private $_items;
    private $_subtotal;
    private $_tax;
    private $_shipping;
    private $_total;
    
    /**
    * Declare the constants, these are the basis for our business logic
    */
    private $_item_price              = 10;
    private $_tax_rate                = .05;
    private $_shipping_rate           = 7;
    private $_free_shipping_threshold = 50;
    
    /**
    * Build the cart
    */
    function __construct( $items = array() ) {
        
        $this->_set_items( $items );
        
        $this->_subtotal = $this->get_subtotal();
        $this->_tax      = $this->get_tax();
        $this->_shipping = $this->get_shipping();
        $this->_total    = $this->get_total();
                                  
    }
    
    public function get_items() {
        
        if ( $this->_items == NULL ) {
            
            return array();
            
        }
        return $this->_items;
        
    }
    
    private function _set_items( $items ) {
        
        foreach ( $items as $item_key => $item ) {
            
            $items[$item_key]['price']    = $this->_item_price;
            $items[$item_key]['subtotal'] = $items[$item_key]['price'] * $item['qty'];
            
        } 
        
        $this->_items = $items;
        
    }
       
    public function get_subtotal() {                
    
        if ( $this->_subtotal == NULL ) {
            
            $this->_subtotal = $this->_calc_subtotal();
            
        }        
        
        return $this->_subtotal;
        
    }
    
    private function _calc_subtotal() {
        
        $subtotal = 0;
        
        foreach ( $this->_items as $item) {
        
            $subtotal += $item['qty'] * $item['price'];    
        }  
        
        return $subtotal;  
        
    }
    
    public function get_tax() {
        
        if ( $this->_tax == NULL ) {
            
            $this->_tax = $this->_calc_tax();   
             
        }               
    
        return $this->_tax;
        
    }    
    
    private function _calc_tax() {
        
        $tax = $this->get_subtotal() * $this->_tax_rate;        
        
        return $tax;  
        
    }    
    
    public function get_shipping() {
        
        if ( $this->_shipping == NULL ) {
            
            $this->_shipping = $this->_calc_shipping();   
             
        }
        
        return $this->_shipping;
        
    }    
    
    private function _calc_shipping() {
        
        $shipping = 0;
        
        //check if the cart subtotal meets the free shipping threshold.
        if ( count($this->_items) && $this->get_subtotal() < $this->_free_shipping_threshold ) {
            
            //if not, shipping is the flat rate 
            $shipping = $this->_shipping_rate;    
        }
        
        return $shipping;  
        
    }      
    
    public function get_total() {
    
        if ( $this->_total == NULL ) {
            
            $this->_total = $this->_calc_total();   
             
        }        
        
        return $this->_total;
    }        
    
    private function _calc_total() {
        
        $total = 0;
        
        $total += $this->get_subtotal();
        $total += $this->get_tax();
        $total += $this->get_shipping();
                
        return $total;
        
    }
        
}
  
?>
