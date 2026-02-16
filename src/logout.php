<?php
session_start();       // 1. Resume the session
session_unset();       // 2. Clear all variables
session_destroy();     // 3. Destroy the session data


header('Location: index.html'); // 4. Redirect
exit();
?>
