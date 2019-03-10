<?php
class Games {
	public static function submit($userId, $Title, $Desc, $Key) {
		echo "funciona";
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_.Ã§Â´+=!$Â·%()Â¿Â¡?*^Ã‡{}[]0123456789';
		$random_directory = substr(str_shuffle($chars), 0, 5);
		if (file_exists('p/usuarios/juegos/' . $random_directory . ''.$_FILES['game']['name'])) {
			echo "<script>alert('un errortremendo \nel juego yaexiste u.u \no quizas eljuego se subio de forma incorrecta, intente una mas');</script>";
		}
		else {
			move_uploaded_file($_FILES['game']['tmp_name'],'p/usuarios/juegos/' . $random_directory . ''.$_FILES['game']['name']);
			$img_name = $_FILES['game']['name'];
			$filename = "p/usuarios/juegos/".$random_directory.$_FILES['game']['name'];
			$md5_file = md5_file($filename);
			if (DB::query('SELECT md5 FROM juegos WHERE uploaded_by=:userid"', array(':userid'=>$userId))) {
				unlink($filename);
				die("<script>alert('subida duplicada, solo seleccione una');</script>");
			}
			else {
				DB::query('INSERT INTO juegos VALUES (\'\', :title, :desc, :keywords, :userid, :category, NOW(), :game, 0, 0, 0)', array(':title'=>$Title, ':desc'=>$Desc, ':keywords'=>$Key, ':userid'=>$userId, ':game'=>$md5_file));
				DB::query('UPDATE juegos SET md5=:game WHERE uploaded_by=:userid', array(':game'=>$md5_file, ':userid'=>$userId));
				die("<script>alert('eljuego se subio!');location.href = 'http://barrarchiverio.7m.pl/p/jimdo/juegos/home.php';</script>");
			}
		}
	}
}
?>