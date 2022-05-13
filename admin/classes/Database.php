<?php

class Database
{
	private $con;
	public function connect(){
		$this->con = new Mysqli("localhost","root","","php_camden");
		return $this->con;
	}
}
?>