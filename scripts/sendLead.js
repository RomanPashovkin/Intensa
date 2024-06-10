document.getElementById('fb-form').addEventListener('submit', function(event) {
	event.preventDefault();

	var formData = new FormData(this);

	//Отправление Ajax-запроса
	var request = new XMLHttpRequest();
	request.open('POST', '/Intensa/formHandler.php', true);
	request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	request.send(formData);

	//Получаем данные из обработчика и выводим в таблице
	request.onload = function() {
		if(request.status === 400) {
			var data = JSON.parse(request.responseText);
			// Если есть ошибки валидации, показываем их на странице
			if (data.length > 0) {
			var errorsHtml = '<ul>';
			data.forEach(function(error) {
				errorsHtml += '<li>' + error + '</li>';
			});
			errorsHtml += '</ul>';
			document.getElementById('thanks').innerHTML = 'Ошибка при отправке формы!';
			document.getElementById('error').innerHTML = errorsHtml;
		}
		}
		if(request.status === 200) {
		var responce = JSON.parse(request.responseText);
		
		for(let key in responce)
			{
				switch (key) {
					case 'fio':
						document.getElementById('error').innerHTML = '';
						document.getElementById('thanks').innerHTML = 'Спасибо за обращение, ' + responce[key];
				}
			}
		}
		else {
			alert('Произошла ошибка. Попробуйте ещё раз.');
		}
	};
	document.getElementById("fb-form").reset();
});