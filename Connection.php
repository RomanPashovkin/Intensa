<?php
class Connection 
{
	private $dbname, $host, $username, $password;
	public $connection;

	public function __construct($dbname, $host, $username, $password)
	{
		$this->dbname = $dbname;
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
	}

	public function connectDb()
	{
		try {
			$this->connection = new PDO("mysql:dbname=$this->dbname; host = $this->host", $this->username, $this->password);
		}
		catch(PDOException $e) {
			die("Ошибка соединения: $e");
		}
	}
}
?>