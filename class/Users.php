<?php
class Users{   
    
    private $itemsTable = "users";      
    public $id;
	public $firstname;
	public $lastname;
	public $email;
	public $password;
	public $country;
	public $birthdate;
    public $name;
    public $description;
    public $price;
    public $category_id;   
    public $created; 
	public $modified; 
    private $conn;
	
    public function __construct($db){
        $this->conn = $db;
    }	
	
	function read(){	
		$stmt = $this->conn->prepare("SELECT * FROM ".$this->itemsTable." WHERE id = ?");
		$stmt->bind_param("s", $this->id);			
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;	
	}

	function rcheck(){
		$stmt = $this->conn->prepare("SELECT id, password FROM ".$this->itemsTable." WHERE id=? AND password=?");
		$stmt->bind_param("ss", $this->id, $this->password);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}
	
	function create(){
		
		$stmt = $this->conn->prepare("
			INSERT INTO ".$this->itemsTable."(`id`, `firstname`, `lastname`, `email`, `password`, `country`, `birthdate`)
			VALUES(?,?,?,?,?,?,?)");
		
		$this->id = htmlspecialchars(strip_tags($this->id));
		$this->firstname = htmlspecialchars(strip_tags($this->firstname));
		$this->lastname = htmlspecialchars(strip_tags($this->lastname));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->password = htmlspecialchars(strip_tags($this->password));
		$this->country = htmlspecialchars(strip_tags($this->country));
		$this->birthdate = htmlspecialchars(strip_tags($this->birthdate));
		
		
		$stmt->bind_param("sssssss", $this->id, $this->firstname, $this->lastname, $this->email, $this->password, $this->country, $this->birthdate);
		
		if($stmt->execute()){
			return true;
		}
	 
		return false;		 
	}

	function check(){
		
		$stmt = $this->conn->prepare("
			SELECT id, password FROM ".$this->itemsTable." WHERE id=? AND password=?");
		
		$this->id = htmlspecialchars(strip_tags($this->id));
		$this->password = htmlspecialchars(strip_tags($this->password));
		
		
		$stmt->bind_param("ss", $this->id, $this->password);
		
		if($stmt->execute()){
			return true;
		}
	 
		return false;		 
	}
		
	function update(){
	 
		$stmt = $this->conn->prepare("
			UPDATE ".$this->itemsTable." 
			SET name= ?, description = ?, price = ?, category_id = ?, created = ?
			WHERE id = ?");
	 
		$this->id = htmlspecialchars(strip_tags($this->id));
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->price = htmlspecialchars(strip_tags($this->price));
		$this->category_id = htmlspecialchars(strip_tags($this->category_id));
		$this->created = htmlspecialchars(strip_tags($this->created));
	 
		$stmt->bind_param("ssiisi", $this->name, $this->description, $this->price, $this->category_id, $this->created, $this->id);
		
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}
	
	function delete(){
		
		$stmt = $this->conn->prepare("
			DELETE FROM ".$this->itemsTable." 
			WHERE id = ?");
			
		$this->id = htmlspecialchars(strip_tags($this->id));
	 
		$stmt->bind_param("s", $this->id);
	 
		if($stmt->execute()){
			return true;
		}
	 
		return false;		 
	}
}
?>