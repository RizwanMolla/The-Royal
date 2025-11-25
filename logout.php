<?php
session_start();
session_destroy();
header('Location: /the-royal/index.php');
exit();
