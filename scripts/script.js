function ajaxSend(path, dataMap = null, method = "GET", callback) {
    // Создаем объект XMLHttpRequest
    let xhr = new XMLHttpRequest();

    // Настраиваем запрос (метод, URL, асинхронность)
    xhr.open(method, path, true);

    // Устанавливаем заголовки (если нужно)
    xhr.setRequestHeader('Content-Type', 'application/json');

    // Определяем обработчик ответа
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Обработка успешного ответа
            callback(xhr.responseText);
        }
    };

    // Формируем данные для отправки
    let data = "";
    if(dataMap != null) {
        dataMap.forEach((val, key, dataMap) => {
            data += key + "=" + val + "&"
        });
    }
// Отправляем запрос
   xhr.send(data);
}