<?php
include('Config.php');
include('Lead.php');

if(isset($_POST['nowSort'])) {
	$sort = $_POST['nowSort'];
	switch ($sort) {
		case 'Любой':
			$leadsList = Lead::getAll($connection);
			break;
		case 'Тула' || 'Москва' || 'Санкт-Петербург':
			$leadsList = Lead::getAllFilter($connection, $sort);
			break;
	}
}

//Создание csv строк
$csv = fopen('php://temp', 'r+');
$keys = array('ФИО', 'Эл.почта', 'Телефон', 'Город');
fputcsv($csv, $keys, ';');
foreach ($leadsList as $lead) {
	$data = [$lead->fio, $lead->email, $lead->phone, $lead->city];
	fputcsv($csv, $data, ';');
}

// Установка заголовков
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="exportLeads.csv"');

// Вывод CSV данных
rewind($csv);
fpassthru($csv);
fclose($csv);
?>