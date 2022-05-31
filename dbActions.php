<?php
function getData($conn){
    $getQuery = "SELECT id, todo, deadline FROM todolist ORDER BY deadline ASC";
    $dbResult = $conn->query($getQuery);
    return $dbResult;
};


?>