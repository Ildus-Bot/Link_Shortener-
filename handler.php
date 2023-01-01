<?php
/* Установка внутренней кодировки в UTF-8 */ 

	header('Content-Type: text/html; charset=UTF-8'); // Заголовок станицы с кодировкой (для корректного отображения в браузере)
	mb_internal_encoding('UTF-8'); // Установка внутренней кодировки в UTF-8
	mb_http_output('UTF-8'); // Установка кодировки UTF-8 входных данных HTTP-запроса
	mb_http_input('UTF-8'); // Установка кодировки UTF-8 выходных данных HTTP-запроса
	mb_regex_encoding('UTF-8'); // Установка кодировки UTF-8 для многобайтовых регулярных выражений 

?>

<?php 

	$url = $_POST['input'];
	$short_url = substr($url, 0, 5);


	if ($short_url != "https" && $short_url != "http:") {
		print("Введите корректный URL");
	}
	else {

		$db_host = 'localhost'; // адрес сервера
	    $db_name = 'url_Cut_url'; // имя базы данных
	    $username = 'root'; // имя пользователя
	    $db_password = ''; // пароль

		$db = mysqli_connect($db_host, $username, $db_password, $db_name);


		$number = 0;
		do {
			
			$match_check = False;
			if (isset($_POST['castomize'])) {
				$number = $number + 1;
				$url_text = str_replace("/", " ", $_POST['castomize']);
				$array_words = explode(' ', $url_text);
				$password = $array_words[3];
				if ($number == 2) {
					$password = "Адрес занят";
					break;
				}
			}
			else {
				$password = generatePassword();
			}
			$foo = "SELECT * FROM `Redirect`";
			$sql_result = mysqli_query($db, $foo);
			$array_tables = mysqli_fetch_all($sql_result);

			foreach ($array_tables as $array_passwords) {

				if ($array_passwords[2] == $password) {
					$match_check = True;
				}
			}

		} while ($match_check);


		$sql = 'INSERT INTO `Redirect` (`id`, `url`, `redirect`) VALUES (NULL, "' . (string)$url . '", "' . $password . '")';
		$result = mysqli_query($db, $sql);

		if ($password == "Адрес занят") {
			print($password);
		}
		else {
			print("https://localhost/" . $password);
		}
		// if ($result == false) {
		//     print("Произошла ошибка при выполнении запроса");
		// }

		mysqli_close($db);

	}


	function generatePassword($length = 8){
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$numChars = strlen($chars);
		$string = '';
		for ($i = 0; $i < $length; $i++) {
			$string .= substr($chars, rand(1, $numChars) - 1, 1);
		}
		return $string;
	}




	
?>