<?php
if(count(get_included_files()) ==1) exit("Direct access not permitted.");

class Config{
    static $url = "http://192.168.254.9/system-rfid/";

    static $title = "Wireless RFID Demo";

    static $database = array(
        'host' => 'localhost',
        'name' => 'demo',
        'username' => 'root',
        'password' => ''
    );
}
?>