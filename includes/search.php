<?php
    if(isset($_POST['submit'])) {
        $search = $_POST['search'];
    
        $query = "select * from posts where post_title like '%$search%' ";
        $search_query = mysqli_query($connection, $query);
    
        if(!$search_query){
            die("query failed" . mysqli_error($connection));
        }
    
        $count = mysqli_num_rows($search_query);
        if($count == 0) {
            echo "<img style='height:80%; width: 90%;' src='resources/img/noresult.png'>;";
    }
?>