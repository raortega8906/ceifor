<?php


class Yoyo{


    public function __construct()
    {
        $this->include();
    }

    public function include(){
        require __DIR__ . '/vendor/autoload.php';
        include "connection.php";
    }

    public function go(){

        $conn = new Connection();

        if ($conn->is_connected()) {
            # code...
            require_once("gmail.php");
            $gmail = new Gmail($conn->get_client());
            return $gmail->readLabels();
        }
        else {
            return $conn->get_unauthentificated_data();
        }
    }
}

$yoyo = new Yoyo();
echo "<!DOCTYPE html><html>";
echo $yoyo->go();
echo "</html>";