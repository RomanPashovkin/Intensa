<?php
include('Config.php'); // Подключение класса для работы с БД
include('Lead.php'); // Подключение класса для "Лида"

session_start();
$errors = array();

if(isset($_POST['csrfToken']) && $_POST['csrfToken'] === $_SESSION['csrfToken']) {
	//Получаем данные из Ajax-запроса
	if(isset($_POST['fio']) && isset($_POST['city']) && isset($_POST['telephone']) && isset($_POST['email'])) {
		$lead = new Lead($_POST['fio'], $_POST['city'], $_POST['telephone'], $_POST['email']);
	}

	//проверка email на корректность
	if (!filter_var($lead->email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Некорректный формат email";
	}

	if (!empty($errors)) {
		http_response_code(400); // Устанавливаем статус 400 для ошибки
		echo json_encode($errors, JSON_UNESCAPED_UNICODE);
		exit;
	}

	//Выполнение запроса для добавления в базу
	$lead->addLead($connection);

	//Получаем данные по нашей записи и возвращаем в формате JSON
	$result = $lead->getLastLead($connection);
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
}

else {
	$errors[] = "Неверный CSRF-токен";
	http_response_code(400);
	echo json_encode($errors, JSON_UNESCAPED_UNICODE);
}

?>