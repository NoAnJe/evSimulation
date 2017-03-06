<?php
require 'evAnalyze.php';
require 'owner.php';
require 'vehicle.php';

class massRun {
    function __construct() {
        $numPeople = $_POST('ev-owners');
        $var = new evAnalyze($numPeople);
    }
}

?>