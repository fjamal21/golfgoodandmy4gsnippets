<?php
// Root directory
define ('SRC', '../src/');

require 'AppController.php';

include SRC . 'Includes/functions.php';

(new Src\App\AppController);
