<?php

session_start();
include 'files/functions.php';

$artist_id = $_GET['artist_id'];
$artist = get_artist_by_artist_id($conn, $artist_id);
$artist_photo = "uploads/" . $artist['artist_photo'];

if (file_exists($artist_photo)) { // checking if a file exists before I delete
    unlink($artist_photo); //Delete a file
}
$artist_location = "uploads/" . $artist['artist_photo'];
if (file_exists($artist_location)) { // checking if a file exists before I delete
    unlink($artist_location); //Delete a file 
}

$get_song_id = "select song_id from songs where aritst_id = '$artist_id'";
$res = $conn->query($get_song_id);
$song_id = $res->fetch_assoc();
if ($song_id != "") {
    $song =  get_top_song_by_song_id($conn, $song_id['song_id']);
    $song_photo = "uploads/" . $song['song_photo'];

    //deleting a song photo
    if (file_exists($song_photo)) { // checking if a file exists before I delete
        unlink($song_photo); //Delete a file
    }

    //Deleting a song file
    $song_mp3_location = "uploads/" . $song['song_mp3'];
    if (file_exists($song_mp3_location)) { // checking if a file exists before I delete
        unlink($song_mp3_location); //Delete a file 
    }

    $sql = "DELETE FROM downloads WHERE song_id  = {$song_id}";
    $conn->query($sql);
    $sql = "DELETE FROM views WHERE song_id  = {$song_id}";
    $conn->query($sql);
    $sql = "DELETE FROM songs WHERE song_id  = {$song_id}";
    $conn->query($sql);
}
$sql = "DELETE FROM artist WHERE artist_id  = {$artist_id}";
if ($conn->query($sql)) {
    message("The Artist and their songs was deleted successfully.", "success");
} else {
    message("Something went wrong while deleting the song.", "danger");
}

header("Location: admin_artists.php");
die();
