<?php
class Members {
	
	private $data;
	private $errors =[];
	private static $fields =['username','password'];
	
	public function __construct($post_data){
		$this->data = $post_data;
	}
	
	public function validateForm(){
		foreach(self::$fields as $field){
			if(!array_key_exists($field,$this->data)){
				trigger_error("$field is not present in data");
			return;
			}
			
		}
		
		
		$this->validateUsername();
        $this->validatePassword();
		return $this->errors;
	}
	
    private function validateUsername(){
		
		$val =trim($this->data['username']);
		
		if(empty($val)){
			$this->addError('username','username cannot be empty');
		}else{
			if(!preg_match('/^[a-zA-Z]{3,6}$/',$val)){
			$this->addError('username','username must be 3-6 chars');
			
			}
		}
	}
	
	private function validatePassword(){
		
		$val =trim($this->data['username']);
		
		if(empty($val)){
			$this->addError('password','password cannot be empty');
		}
	}
	
	
	private function addEror($key,$val){
		$this->errors[$key] = $val;
	}
	
}

?>