<?php
include('Config.php');
include('Lead.php');

if(isset($_POST['sortingCity'])) {
	$sort = $_POST['sortingCity'];
	switch ($sort) {
		case 'Любой':
			$leadsList = Lead::getAll($connection);
			break;
		case 'Тула' || 'Москва' || 'Санкт-Петербург':
			$leadsList = Lead::getAllFilter($connection, $sort);
			break;
	}
}
else {
	$leadsList = Lead::getAll($connection);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel = "stylesheet" href = "/Intensa/style/leadsList.css">
	<title>Document</title>
</head>
<body>
<h1 id = "home-title">Просмотр всех лидов</h1>
<a id = 'leadsList-title'>Список лидов</a>

<div class = 'userSort'>
		<form method = "post" action = "/Intensa/leadsList.php" class = "sortForm" onsubmit="submitSort()">
			<label for = "sortingCity">Отфильтровать по городу:&nbsp</label>
			<select id = "sortingCity" name = "sortingCity">
				<option value = "Любой">Любой</option>
				<option value = "Тула">Тула</option>
				<option value = "Москва">Москва</option>
				<option value = "Санкт-Петербург">Санкт-Петербург</option>
			</select>
			<input class = 'sortButton' type = 'submit' name = 'sortLeads' value = "Отфильтровать">
		</form>
</div>

<div id ='leadsList-block'>
	<?php foreach ($leadsList as $lead): ?>
		<div class = 'leadsList-item'>
			<div class="leadsList-item-fio">
				<a>ФИО:&nbsp</a><span><?php echo $lead->fio; ?></span>
			</div>
			<div class="leadsList-item-email">
				<a>Электронная почта:&nbsp</a><span><?php echo $lead->email; ?></span>
			</div>
			<div class="leadsList-item-phone">
				<a>Телефон:&nbsp</a><span><?php echo $lead->phone; ?></span>
			</div>
			<div class="leadsList-item-city">
				<a>Город:&nbsp</a><span><?php echo $lead->city; ?></span>
			</div>
		</div>
	<?php endforeach; ?>
</div>

<div class = 'usersCsv'>
		<form method = "post" id = "createCsv" class = "createCsv">
			<input type = "hidden" name = "nowSort" value = "<?php if (isset($_POST['sortingCity'])) {echo $_POST['sortingCity'];} else {echo "Любой";} ?>">
			<input class = 'csvButton' type = 'submit' name = 'getCsv' value = "Выгрузка в CSV">
		</form>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function(){
		var item = localStorage.getItem('city');
		var select = document.getElementById("sortingCity");
		select.value = item;
	});
	function submitSort(){
		var select = document.getElementById("sortingCity");
		var value = select.options[select.selectedIndex].value;
		localStorage.setItem('city', value);
}
</script>

<script src = "/Intensa/scripts/csvAjax.js"></script>
</body>
</html>