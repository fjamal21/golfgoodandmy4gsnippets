<?php
namespace Src\Modules\NotFound;

use Src\Includes\SuperClasses\AbstractController;

class Controller extends AbstractController
{
    /*
     * Run
     */
    public function run()
    {
        $this->display();
    }
    
    /*
     * Display
     */
    protected function display()
    {
        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf8">
    <title>404 Not Found</title>
</head>
<body>
    <h1>404 Not Found</h1>
    <p>That resource doesn\'t exists. Try going <a href="/">HOME</a></p>
</body>
</html>';

        echo $html;
    }
}
