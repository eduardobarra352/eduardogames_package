<?php
class Games {
	public static function submit($userId, $Title, $Desc, $Key, $Type, $Privacy, $Category, $Thumbnail) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_0123456789';
		$game_id = substr(str_shuffle($chars), 0, 10);
		$game_id = md5($game_id);
		if (($_FILES['game']['type']=='application/x-shockwave-flash')) {
			if ($_FILES['game']['size'] < 10240000) {
				$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_0123456789';
				$random_directory = substr(str_shuffle($chars), 0, 10);
				if (file_exists('juegos/' . $random_directory . ''.$_FILES['game']['name'])) {
					echo "<script>alert('un errortremendo: el juego yaexiste u.u o quizas eljuego se subio de forma incorrecta, intente una mas');</script>";
				}
				else {
					move_uploaded_file($_FILES['game']['tmp_name'],'juegos/' . $random_directory . ''.$_FILES['game']['name']);
					$img_name = $_FILES['game']['name'];
					$filename = "https://eduardobarra352.github.io/eduardogames_package/p/usuarios/juegos/".$random_directory.$_FILES['game']['name'];
					//$md5_file = md5_file($filename);
					if (DB::query('SELECT file FROM juegos WHERE uploaded_by=:userid AND game_id=:gameid', array(':userid'=>$userid, ':gameid'=>$random_directory))) {
						unlink($filename);
						die("<script>alert('oOPS, intente mas alrato, pero guiate de estos ejemplos: 1- es posible detectar un archivo duplicado. 2- nombra el archivo sin espacios. 3- solo se puede subir un solo archivo.');location.href = location.href;</script>");
					}
					else {
						DB::query('INSERT INTO juegos VALUES (\'\', :gameid, :title, :desc, :keywords, :userid, :category, :type, :privacy, :thumbnail, (NOW()-INTERVAL 5 HOUR), :game, :options, 0, 0, 0)', array(':gameid'=>$random_directory, ':title'=>$title, ':desc'=>$desc, ':keywords'=>$keywords, ':userid'=>$userid, ':category'=>$category, ':type'=>$type, ':privacy'=>$privacy, ':thumbnail'=>$thumbnail, ':game'=>$filename, ':options'=>$opciones));
						die("<script>alert('eljuego se subio!');location.href = 'http://barrarchiverio.7m.pl/p/jimdo/juegos/home';</script>");
					}
				}
			}
			else {
				echo "<script>alert('el archivo debe pesar menos de 10MB');</script>";
			}
		}
		else {
			echo "<script>alert('debe ser un archivo flash player, intente');</script>";
		}
	}
}
?>