<?php

class Lead {
public $fio, $email, $phone, $city;

public function __construct($fio, $city, $phone, $email)
{
	$this->fio = $fio;
	$this->email = $email;
	$this->phone = $phone;
	$this->city = $city;
}

//Добаваление лида
public function addLead($connection)
{
	$insertQuery = sprintf("Insert into leads (fio, address, telephone, email) values(%s, %s, %s, %s)",
	$connection->connection->quote($this->fio), $connection->connection->quote($this->city), $connection->connection->quote($this->phone), $connection->connection->quote($this->email));
	$stmt = $connection->connection->prepare($insertQuery);
	$stmt->execute();
}

//Получение последнего добавленного лида
public function getLastLead($connection)
{
	$insertedId = $connection->connection->lastInsertId();

	//Получаем данные по нашей записи и возвращаем в формате JSON
	$result = $connection->connection->query("Select fio, address, telephone, email from leads where id = $insertedId")->fetch(PDO::FETCH_ASSOC);
	return $result;
}

//Получение всех лидов в таблице
static public function getAll($connection)
{
	$getAllQuery = "Select * from leads order by id DESC";
	$result = $connection->connection->prepare($getAllQuery);
	$result->execute();
	$leadsList = [];
	foreach($result as $row) {
		$lead = new Lead($row['fio'], $row['address'], $row['telephone'], $row['email']);
		array_push($leadsList, $lead);
	}
	return $leadsList;
}

//Получение всех лидов отфильтрованных по городу
static public function getAllFilter($connection, $filter)
{
	$getAllFilterQuery = sprintf("Select * from leads where address = %s order by id DESC", $connection->connection->quote($filter));
	$result = $connection->connection->prepare($getAllFilterQuery);
	$result->execute();
	$leadsList = [];
	foreach($result as $row) {
		$lead = new Lead($row['fio'], $row['address'], $row['telephone'], $row['email']);
		array_push($leadsList, $lead);
	}
	return $leadsList;
}

}
?>