<?php
if(count(get_included_files()) ==1) exit("Direct access not permitted.");

class Input{
    public function get($input = "", $return = null){
        return isset($_GET[$input])?$_GET[$input]:$return;
    }

    public function post($input = "", $return = null){
        return isset($_POST[$input])?$_POST[$input]:$return;
    }

    public function get_post($input = "", $return = null){
        $post = isset($_POST[$input])?$_POST[$input]:$return;
        $get = isset($_GET[$input])?$_GET[$input]:$return;
        return $get!=$return?$get:($post!=$return?$post:$return);
    }

    public function post_get($input = "", $return = null){
        $post = isset($_POST[$input])?$_POST[$input]:$return;
        $get = isset($_GET[$input])?$_GET[$input]:$return;
        return $post!=$return?$post:($get!=$return?$get:$return);
    }
}

$input = new Input();
?>