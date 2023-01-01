<?php 
	$url = $_SERVER['REQUEST_URI'];
	$url = explode('?', $url);
	$url = $url[0];
	$url = str_replace("/", "", $url);
	$url = str_replace(".", " ", $url);
	$url = explode(" ", $url);



	$db_host = 'localhost'; // адрес сервера
    $db_name = 'url_Cut_url'; // имя базы данных
    $username = 'root'; // имя пользователя
    $db_password = ''; // пароль

	$db = mysqli_connect($db_host, $username, $db_password, $db_name);
	// mysqli_set_charset($con, "utf8");

	if ($db == false) {
	    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
	}
	else {
	    print("Соединение установлено успешно");
	}

	$foo = "SELECT * FROM `Redirect`";
	$sql_result = mysqli_query($db, $foo);
	$array_tables = mysqli_fetch_all($sql_result);

	foreach ($array_tables as $array_passwords) {

		if ($array_passwords[2] == (string)$url[0]) {
			header('Location: ' . $array_passwords[1], true, 301);
		}
	}

	echo $url;
?>