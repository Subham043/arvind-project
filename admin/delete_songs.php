<?php
session_start();
include '../files/functions.php';
if (isset($_GET['song_id'])) {
    $song_id = $_GET['song_id'];
    $song =  get_top_song_by_song_id($conn, $song_id);
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
    if ($conn->query($sql)) {
        $_SESSION['message'] = "The song was deleted successfully.";
    } else {
        $_SESSION['message'] = "Something went wrong while deleting the song.";
    }
    header("Location: manage_songs.php");
    die();
}
if (isset($_GET['music'])) {
    $music_id = $_GET['music'];
    $sql = "DELETE FROM karoke WHERE id  = {$music_id}";
    $conn->query($sql);
    if ($conn->query($sql)) {
        $_SESSION['message'] = "The Karoke Music was deleted successfully.";
    } else {
        $_SESSION['message'] = "Something went wrong while deleting the song.";
    }
    header("Location: manage_karoke.php");
    die();
}
