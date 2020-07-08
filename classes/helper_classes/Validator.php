<?php

use function PHPSTORM_META\type;

class Validator {

    protected $di;

    protected $rules = ['required', 'minlength', 'maxlength', 'unique', 'email', 'phone'];

    protected $messages = [
        'required' => 'The :field field is required.',
        'minlength' => "The :field field must be a minimum of :satisfier characters.",
        'maxlength'=> "The :field field must be a maximum of :satisfier characters.",
        'email' => 'The :field is not a valid email address.',
        'unique' => 'The :field is already taken.',
        'phone' => 'The :field is not a valid phone number.',
        'min' => 'The :field field must be greater than or equal to :satisfier.',
        'max' => 'The :field field must be less than or equal to :satisfier.'
    ];


    public function __construct(DependancyInjector $di) {
        $this->di = $di;
    }

    public function check($items, $rules) {
        foreach($items as $item => $value) {
            if(in_array($item, array_keys($rules))) {
                $this->validate([
                    'field' => $item,
                    'value' => $value,
                    'rules' => $rules[$item]
                ]);
            }
        }
        return $this;
    }


    public function validate($item) {
        $field = $item['field'];
        $is_required = isset($item['rules']['required']);
        foreach($item['rules'] as $rule => $satisfier) {
            if(!call_user_func_array([$this, $rule], [$field,$item['value'],$satisfier, $is_required])) {
                // error handling
                $this->di->get('errorhandler')->addError(str_replace([':field',':satisfier'], [$field, $satisfier], $this->messages[$rule]),$field);
            }
        }
    }

    public function required($field, $value, $satisfier, $is_required) {

        if ($satisfier):
            if(is_array($value))
                return !empty($value);
            else
            return !empty(trim($value));
        else:
            return true;
        endif;
    }

    public function minlength($field, $value, $satisfier, $is_required) {
        if(!$is_required && !$value){
            return true;
        }
        if(is_array($value)){
            $flag = true;
            foreach($value as $val){
                if (mb_strlen($val) < $satisfier) {
                    $flag = false;
                    break;
                }
            }
            return $flag;
        }
        return mb_strlen($value) >= $satisfier;
    }

    public function maxlength($field, $value, $satisfier, $is_required) {
        if(!$is_required && !$value){
            return true;
        }
        if(is_array($value)) {
            $flag = true;
            foreach($value as $val){
                if ( mb_strlen($val) > $satisfier) {
                    $flag = false;
                    break;
                }
            }
            return $flag;
        }
        return mb_strlen($value) <= $satisfier;
    }

    public function min($field, $value, $satisfier, $is_required) {
        if(!$is_required && !$value){
            return true;
        }
        if(is_array($value)) {
            $flag = true;
            foreach($value as $val){
                if ((int)$val < $satisfier) {
                    $flag = false;
                    break;
                }
            }
            return $flag;
        }
        return (int)$value >= $satisfier;
    }

    public function max($field, $value, $satisfier, $is_required) {
        if(!$is_required && !$value){
            return true;
        }
        if(is_array($value)) {
            $flag = true;
            foreach($value as $val){
                if ((int)$val > $satisfier) {
                    $flag = false;
                    break;
                }
            }
            return $flag;
        }
        return (int)$value <= $satisfier;
    }

    public function unique($field, $value, $satisfier, $is_required) {
        if(!$is_required && !$value){
            return true;
        }
        return !$this->di->get('database')->exists($satisfier, [$field=>$value]);
    }

    public function email($field, $value, $satisfier, $is_required) {
        if(!$is_required && !$value){
            return true;
        }
        if ($satisfier):
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        endif;
    }

    public function phone($field, $value, $satisfier, $is_required) {
        if(!$is_required && !$value){
            return true;
        }
        return strlen(preg_replace('/[^0-9]{10}/', '', $value)) == 10;
    }

    public function fails() {
        return $this->di->get('errorhandler')->hasErrors();
    }

    public function errors() {
        return $this->di->get('errorhandler');
    }

}



?>
