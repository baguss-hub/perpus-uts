<?php
session_start(); // ini jangan lupa. hanya saja untuk file dalam pages tidak perlu, karena sudah dipanggil di index.php

$_SESSION = []; // kosongkan session
session_destroy(); // hancurkan session

header("location: login.php"); // arahkan ke login