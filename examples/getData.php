<?php 
    if(isset($_POST["key"])){
        $key=$_POST["key"];
        $str = str_replace( ' ', '%20', $key );
        $string = file_get_contents("http://localhost:9200/_search?q=$str&size=1000");
        echo $string;
    }
    
?>