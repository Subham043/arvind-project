<?php
$conn = new mysqli("localhost", "root", "", "hmusic");

function get_user_by_username($conn, $username)
{
	$sql = "SELECT * FROM users WHERE username = '{$username}'";
	$res = $conn->query($sql);
	$data = $res->fetch_assoc();
	if ($data == null) {
		return array();
	} else {
		return $data;
	}
}
/*  
  
            [] => 1592902550_15623277316181_IMG_1965.jpeg
            [] => 2
            [] => 1592903501_24985636169454_Jizzle_-_Jealousy_(
            [] => 1592903501_75222169227962_song_pic.png
            [] => 1592904725
            [] => 5
            [] => Jealousy 
            [view_id] => 2
            [user_id] => 7
            [view_time] => 1592904925
*/


// get top 10 songs
function get_latest_songs($conn)
{
	$songs = get_all_songs($conn);
	$_songs = array();

	foreach ($songs as $key => $song) {
		$song['view_count'] = get_song_views($conn, $song['song_id']);
		$song['download_count'] = get_song_downloads($conn, $song['song_id']);
		array_push($_songs, $song);
	}

	$i  = 0;
	$j  = 0;

	for ($j = 0; $j < (count($_songs) - 1); $j++) {
		for ($i = 0; $i < (count($_songs) - 1); $i++) {
			if ($_songs[$i]['song_id'] < $_songs[$i + 1]['song_id']) {
				$temp = $_songs[$i];
				$_songs[$i] = $_songs[$i + 1];
				$_songs[$i + 1] = $temp;
			}
		}
	}




	return $_songs;
}




// get top 10 songs
function get_top_song_by_song_id($conn, $song_id)
{

	$sql = "SELECT * FROM artist,songs
			WHERE
				songs.aritst_id = artist.artist_id AND
				song_id = {$song_id}				
			ORDER BY artist_name ASC";
	$res = $conn->query($sql);
	$song = $res->fetch_assoc();
	$song['view_count'] = get_song_views($conn, $song_id);
	$song['download_count'] = get_song_downloads($conn, $song_id);

	return $song;
}



// get top 10 songs
function get_by_artist_id($conn, $artist_id)
{
	$songs = get_all_songs($conn);
	$_songs = array();

	foreach ($songs as $key => $song) {
		$song['view_count'] = get_song_views($conn, $song['song_id']);
		$song['download_count'] = get_song_downloads($conn, $song['song_id']);
		if ($artist_id == $song['artist_id']) {
			array_push($_songs, $song);
		}
	}

	$i  = 0;
	$j  = 0;

	for ($j = 0; $j < (count($_songs) - 1); $j++) {
		for ($i = 0; $i < (count($_songs) - 1); $i++) {
			if ($_songs[$i]['view_count'] < $_songs[$i + 1]['view_count']) {
				$temp = $_songs[$i];
				$_songs[$i] = $_songs[$i + 1];
				$_songs[$i + 1] = $temp;
			}
		}
	}
	return $_songs;
}




// get top 10 songs
function get_top_songs($conn)
{
	$songs = get_all_songs($conn);
	$_songs = array();

	foreach ($songs as $key => $song) {
		$song['view_count'] = get_song_views($conn, $song['song_id']);
		$song['download_count'] = get_song_downloads($conn, $song['song_id']);
		array_push($_songs, $song);
	}

	$i  = 0;
	$j  = 0;

	for ($j = 0; $j < (count($_songs) - 1); $j++) {
		for ($i = 0; $i < (count($_songs) - 1); $i++) {
			if ($_songs[$i]['view_count'] < $_songs[$i + 1]['view_count']) {
				$temp = $_songs[$i];
				$_songs[$i] = $_songs[$i + 1];
				$_songs[$i + 1] = $temp;
			}
		}
	}
	return $_songs;
}
function get_searched_songs($conn, $searched_text)
{
	$searched_text = strtolower($searched_text);
	$ress = 1;
	if ($ress > 0) {
		$songs = mysqli_query($conn, "SELECT * FROM artist,songs WHERE songs.aritst_id = artist.artist_id and songs.verify=1 and (type_id like '$searched_text%' or artist.artist_name like '$searched_text%' or songs.song_name like '$searched_text%') ORDER BY artist_name ASC ");
		$_songs = array();

		if (mysqli_num_rows($songs) > 0) {
			foreach ($songs as $key => $song) {
				$song['view_count'] = get_song_views($conn, $song['song_id']);
				$song['download_count'] = get_song_downloads($conn, $song['song_id']);
				array_push($_songs, $song);
			}

			$i  = 0;
			$j  = 0;

			for ($j = 0; $j < (count($_songs) - 1); $j++) {
				for ($i = 0; $i < (count($_songs) - 1); $i++) {
					if ($_songs[$i]['view_count'] < $_songs[$i + 1]['view_count']) {
						$temp = $_songs[$i];
						$_songs[$i] = $_songs[$i + 1];
						$_songs[$i + 1] = $temp;
					}
				}
			}
		}
		return $_songs;
	} else {
		return false;
	}
}

//song view count
function get_song_downloads($conn, $song_id)
{
	$sql = "SELECT count(download_id) AS download  FROM downloads WHERE song_id = {$song_id}";
	$res = $conn->query($sql);
	$views = array();
	$data = $res->fetch_assoc();
	return $data['download'];
}



//song view count
function get_song_views($conn, $song_id)
{
	$sql = "SELECT count(view_id) AS view_count  FROM views WHERE song_id = {$song_id}";
	$res = $conn->query($sql);
	$views = array();
	$data = $res->fetch_assoc();
	return $data['view_count'];
}

function check_likes($conn, $user_id, $song_id)
{
	$ch_like = mysqli_query($conn, "SELECT * From likes where user_id ='$user_id' and songs_id = '$song_id'");
	return (mysqli_num_rows($ch_like) > 0);
}
function get_likes($conn, $song_id)
{
	$sql = "SELECT Count(*) as total from likes where songs_id = '$song_id' ";
	$res = mysqli_query($conn, $sql);
	$likes = $res->fetch_assoc();
	return $likes['total'];
}

// Get all songs
function get_all_songs($conn)
{
	$sql = "SELECT * FROM artist,songs
			WHERE
				songs.aritst_id = artist.artist_id and verify=1
			ORDER BY artist_name ASC";
	$res = $conn->query($sql);
	$songs = array();
	while ($data = $res->fetch_assoc()) {
		array_push($songs, $data);
	}
	return $songs;
}




function record_view($conn, $song_id, $user_id)
{
	$view_time = time();
	$res = mysqli_query($conn, "SELECT * FROM views where user_id = '$user_id'");
	if (mysqli_num_rows($res) <= 0) {
		$sql = "INSERT INTO `views` 
			(song_id,user_id,view_time)
			VALUES 
			(
				{$song_id},{$user_id},'{$view_time}'
			)
	";

		if ($conn->query($sql)) {
		} else {
		}
	}
}




function record_dowload($conn, $song_id, $user_id)
{
	$download_time = time();
	$sql = "INSERT INTO `downloads` 
			(song_id,user_id,download_time)
			VALUES 
			(
				{$song_id},{$user_id},'{$download_time}'
			)
	";

	if ($conn->query($sql)) {
	} else {
	}
}




function get_artist_by_artist_id($conn, $artist_id)
{
	$sql = "SELECT * FROM artist WHERE artist_id = {$artist_id};";
	$res = $conn->query($sql);
	$data = $res->fetch_assoc();
	return $data;
}





function get_all_artists($conn, $user_id)
{
	$sql = "SELECT * FROM artist where user_id = '$user_id' ORDER BY artist_name ASC";
	$res = $conn->query($sql);
	$artists = array();
	while ($data = $res->fetch_assoc()) {
		array_push($artists, $data);
	}
	return $artists;
}


function message($body, $type)
{
	$_SESSION['message']['body'] = $body;
	$_SESSION['message']['type'] = $type;
}

function phpmailsend($to, $subject, $content)
{
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = 'smtp.gmail.com'; //
	$mail->SMTPAuth = TRUE;
	$mail->Username = "onlinemelody4@gmail.com";
	$mail->Password = "online_melody7";
	$mail->SMTPSecure = 'ssl'; // tls or ssl 
	$mail->Port     = "465"; //465

	$mail->SMTPDebug = 0;
	$mail->SetFrom('onlinemelody4@gmail.com', "Online Melody");

	$mail->AddAddress($to); //we can add here multiple email 

	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $content;


	if (!$mail->Send()) {
		echo $mail->ErrorInfo;
		return false;
	} else {
		return true;
	}
}
