<?php
session_start();
include 'files/functions.php';
require_once("files/header.php");
$top_songs = get_top_songs($conn);

?>
<div class="container">
    <ul class="list-group mt-md-3">
        <li class="list-group-item">
            <h2 class="display-4">TOP 10 Hits</h2>
        </li>
    </ul>
</div>