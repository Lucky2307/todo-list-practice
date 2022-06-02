<?php
include "dbConnect.php";

// Check intent
$intent = $_POST["intent"];
switch ($intent) {
    case 'getTable':
        getData();
        break;
    case 'add':
        addData(
            $_POST["todo"],
            $_POST["deadline"]
        );
        break;
    case 'remove':
        removeData(
            $_POST["id"]
        );
        break;
}




// Functions
function getData()
{
    global $conn;
    $getQuery = "SELECT id, todo, deadline FROM todolist ORDER BY deadline ASC";
    $dbResult = $conn->query($getQuery);
    if ($dbResult->num_rows > 0) {
        $rows = $dbResult->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            echo "<tr>";
            echo "<td><a href=\"#\" onclick=\"setAction(this)\" style=\"color: black\"  
            data-action=\"remove\" 
            data-row-id=\"" . $row["id"] . "\" 
            data-row-todo=\"" . $row["todo"] . "\" 
            data-row-deadline=\"". $row["deadline"] . "\"
            ><i class=\"fas fa-trash-alt\" id=\"removeButton\"></i></a></td>";
            echo "<td>" . $row["todo"] . "</td>";
            echo "<td>" . $row["deadline"] . "</td>";
            echo "</tr>";
        }
    }
};

function addData(string $name, string $deadline)
{
    global $conn;
    $insertStatement = $conn->prepare("INSERT INTO todolist (todo, deadline) VALUES (?, ?)");
    $insertStatement->bind_param('ss', $name, $deadline);
    if ($insertStatement->execute() === TRUE) {
        echo "Added";
    } else {
        echo "Error: " . $insertStatement . "<br>" . $conn->error;
    };
}

function removeData(int $id){
    global $conn;
    $removeStatement = $conn->prepare("DELETE FROM todolist where id=?");
    $removeStatement->bind_param('i', $id);
    if ($removeStatement->execute() === TRUE) {
        echo "Removed";
    } else {
        echo "Error: " . $removeStatement . "<br>" . $conn->error;
    };
}
?>