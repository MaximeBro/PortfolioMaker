<?php

session_start();
session_destroy();
Header("Location: ../Consultation.php");

?>