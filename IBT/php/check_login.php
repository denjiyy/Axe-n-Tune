<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        echo "not_logged_in";
    }