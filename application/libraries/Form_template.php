<?php

class Form_template{
              
    public function __construct(){
        
    }

    /**
     * Return input text with label
     * @param label String 
     * @param name String
     * @param placeholder String
     * @param value String    
     * 
     * @return String html text
     */

    public function text($label, $name, $placeholder=null, $value=null){
        if($placeholder == null){
            $placeholder = 'Enter your '. $name;
        }
        return "
        <label class='col-form-label' for='" . $name . "'>" . $label . "</label>
        <input class='form-control' id='". $name . "' type='text' name='" . $name . "' placeholder='" . $placeholder . "' value='" . $value . "'>
        
        
        ";

    }

    public function password($label, $name, $placeholder = null, $value = null)
    {
        if ($placeholder == null) {
            $placeholder = 'Enter your ' . $name;
        }
        return "
        <label class='col-form-label' for='" . $name . "'>" . $label . "</label>
        <input class='form-control' id='" . $name . "' type='password' name='" . $name . "' placeholder='" . $placeholder . "' value='" . $value . "'>
        
        
        ";
    }

    public function email($label, $name, $placeholder = null, $value = null)
    {
        if ($placeholder == null) {
            $placeholder = 'Enter your ' . $name;
        }
        return "
        <label class='col-form-label' for='" . $name . "'>" . $label . "</label>
        <input class='form-control' id='" . $name . "' type='email' name='" . $name . "' placeholder='" . $placeholder . "' value='" . $value . "'>
        
        
        ";
    }

    public function select($label, $name, $option, $selected = null, $readonly=false)
    {
        $select_option = "<option value='0'>Please select</option>";
        foreach ($option as $key => $value) {
            if (!is_object($value)) $value = (object) $value;
            $is_selected = ($selected != null && $value->id == $selected) ? 'selected' : '';
            $select_option = $select_option."<option " . $is_selected . " value='".$value->id."'>".$value->name."</option>";
        }

        $readonly = ($readonly) ? 'readonly' : '';
       

        return "
        <label class='col-form-label' for='" . $name . "'>" . $label . "</label>
        <select class='form-control' id='select1' name='" . $name . "' ". $readonly .">
            " . $select_option . "
        </select>
        ";
    }

    public function radio($label, $name, $option, $selected = null)
    {
       
        $radio_option = '';
        $i = 1;
        foreach ($option as $key => $value) {
            if (!is_object($value)) $value = (object) $value;
            $is_selected = ($selected != null && $value->value == $selected || $i==1) ? 'checked' : '';
            
            $radio_option = $radio_option . "
                <div class='form-check'>
                    <input class='' id='radioopt_".$i."' type='radio' value='".$value->value."' name='".$name."' ".$is_selected.">
                    <label class='' for='radioopt_".$i."'>".$value->label."</label>
                </div>
            ";
            $i++;
        }
        return "
        <div class='row'>
            <div class='col-12'><label class='col-form-label' for='" . $name . "'>" . $label . "</label></div>
            <div class='col-12'>
            ".$radio_option. "
            </div>
        </div>";
    }

    /**
     * Return textarea with label
     * @param label String 
     * @param name String
     * @param placeholder String
     * @param value String    
     * 
     * @return String html text
     */

    public function textarea($label, $name, $placeholder=null, $value = null)
    {
        if ($placeholder == null) {
            $placeholder = 'enter your ' . $name;
        }
        return "
            <label class='col-form-label' for='" . $name . "'>" . $label . "</label>
          
            <textarea name='" . $name . "' id='' cols='30' rows='10' class='form-control'placeholder='" . $placeholder . "'>" . $value . "</textarea>
          
            
            ";
    }

    /**
     * Return submit button
     * @return String html text
     */

    public function submit(){
        return "
             <div class='col-12'>
                <div class='float-right'>                    
                <button class='btn btn-outline-primary' type='reset'> Reset</button>    
                <button class='btn btn btn-primary px-5' type='submit'> Submit</button>
                     
                </div>
            </div>
        ";
    }

    



}
