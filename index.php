<?php
session_start();
$csrfToken = bin2hex(random_bytes(32)); // Генерация случайного csrf токена из 32 байт
$_SESSION['csrfToken'] = $csrfToken;

$cityArray = ['Тула','Москва','Санкт-Петербург'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel = 'stylesheet' href = "/Intensa/style/fbForm.css">
	<script src="https://unpkg.com/imask"></script>
	<title>Форма сбора лидов</title>
</head>
<body>
	<div id = "feedback-form">
		<h1 class="form-title">Свяжитесь с нами</h1>
		<form id = "fb-form">
			<input placeholder="ФИО" type = "text" id = "fio" class = "form-field" name = "fio" required><br>
			<input placeholder="Телефон" type = "tel" id = "telephone" class = "form-field" name = "telephone" required><br>
			<input placeholder="Эл.почта" type = "email" id = "email" class = "form-field" name = "email" required><br>
			<select id = "city" class = "form-field" name = "city" required>
				<?php foreach($cityArray as $city): ?>
				<option class = "city-options" value = '<?php echo $city?>'><?php echo $city?></option>
				<?php endforeach ?>
			</select><br>
			<input type = "hidden" id = "csrfToken" name = "csrfToken" value = <?php echo $csrfToken?>><br>
			<input type = "submit" value = "Отправить заявку" id = "submit-btn" class="form-submit" >
		</form>
		<a id = "thanks"></a>
		<a id = "error"></a>
	</div>

	<script src = "/Intensa/scripts/sendLead.js"></script>

	<script>
		var tel = document.querySelector('input[type="tel"]');
		var dispatchMask = IMask(tel, {
		mask: [
			{
				mask: '+7 (000) 000-00-00',
				startsWith: '7',
				lazy: false,
				country: 'Russia'
			},
			{
				country: 'Belarus',
				mask: '375 (00) 000-00-00',
				lazy: false,
				startsWith: '3'
			},
			{
				country: 'Kazakhstan',
				mask: '+7 (000) 000-00-00',
				lazy: false,
				startsWith: '7'
			}
		],
		dispatch: function (appended, dynamicMasked) {
			var number = (dynamicMasked.value + appended).replace(/\D/g,'');
			return dynamicMasked.compiledMasks.find(function (m) {
				return number.indexOf(m.startsWith) === 0;
				});
			}
		})
	</script>
</body>
</html>