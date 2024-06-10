document.getElementById('createCsv').addEventListener('submit', function(event){
	event.preventDefault();

	var formData = new FormData(this);

	//Отправление Ajax-запроса
	var request = new XMLHttpRequest();
	request.open('POST', '/Intensa/csvCreate.php', true);
	request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	request.send(formData);
	request.responseType = 'blob';

	request.onload = function() {
		if (request.status == 200) {
			const blob = new Blob([new Uint8Array([0xEF, 0xBB, 0xBF]), request.response], { type: 'text/csv' });

			var link = document.createElement('a');
			link.href = window.URL.createObjectURL(blob);
			link.download = 'exportLeads.csv';
			link.click();
		}
	};
});