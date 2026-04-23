<?php

/**
 * Redirecionamento para a pasta public
 * Este arquivo garante que o Laravel funcione corretamente no cPanel
 */

header('Location: /public/index.php');
exit;
