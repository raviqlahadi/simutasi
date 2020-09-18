<?php

    class Alert{
              
        public function __construct(){
           
        }

        public function set_alert($type = 'info', $message = ''){
            $alert = 
            "<div class='alert alert-".$type. " alert-dismissible fade show' role='alert'>
                " . $message . "
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>";
            return $alert;
        }

      
        

    }

?>