<!DOCTYPE html>
<html>
    <?php
        include "dbConnect.php"
    ?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/b1fed987ee.js" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="col">
                    <div class="col">
                        <div class="row" id="header">
                            <h1 class="display-1 text-center">PHP/MySQL Test Project</h1>
                            <h5 class="display-5 text-center"><small class="text-muted">A PHP-HTML demo page with get, insert, and delete to MySQL database</small></h5>
                        </div>
                        <div class="row" id="content">
                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $name = $_POST['toDo'];
                                $deadline = $_POST['when'];
                                echo $name;
                                echo $deadline;

                                $insertStatement = $conn->prepare("INSERT INTO todolist (todo, deadline) VALUES (?, ?)");
                                $insertStatement->bind_param('ss', $name, $deadline);
                                if ($insertStatement->execute() === TRUE) {
                                    echo "Added";
                                } else {
                                    echo "Error: " . $query . "<br>" . $conn->error;
                                }
                            }

                            $getQuery = "SELECT id, todo, deadline FROM todolist ORDER BY deadline ASC";
                            $dbResult = $conn->query($getQuery);
                            ?>

                            <div class="col">
                                You have <b><?php echo $dbResult->num_rows;?></b> thing(s) to do
                            </div>

                            <table id="todoTable" class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;"></th>
                                        <th style="width: 60%;">What to do</th>
                                        <th style="width: 35%;">Deadline</th>
                                    </tr>
                                </thead>
                                <?php
                                if ($dbResult->num_rows > 0) {
                                    $rows = $dbResult->fetch_all(MYSQLI_ASSOC);
                                    foreach ($rows as $row) {
                                        echo "<tr>";
                                        echo "<td><a href=\"#\" onclick=\"setId(this)\" style=\"color: black\" data-bs-toggle=\"modal\" data-bs-target=\"#confirmationModal\" data-row-id=\"" . $row["id"] . "\"><i class=\"fas fa-trash-alt\" id=\"removeButton\"></i></a></td>";
                                        echo "<td>" . $row["todo"] . "</td>";
                                        echo "<td>" . $row["deadline"] . "</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </table>
                            <form action="hello.php" method="post">
                                To do: <input type="text" name="toDo" required>
                                When: <input type="date" name="when" required>
                                <input type="submit" value="Add" class="btn btn-primary">
                            </form>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="confirmationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmationModalLabel">Confirm action</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            Are you sure you want to delete? (This action cannot be undone)
                                        </p>
                                        <p id="rowId">
                                            0
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button id="removeRowButton" type="button" onclick="removeRow(this)" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

<script>
    function removeRow(r) {
        var i = r.parentNode.parentNode.rowIndex;
        document.getElementById("todoTable").deleteRow(i);
    };

    function setId(r) {
        var id = r.getAttribute("data-row-id");
        document.getElementById("rowId").innerHTML = id;
        document.getElementById("removeRowButton").setAttribute("data-row-id", id)
    };
</script>

<style>
    #removeButton {
        padding: 5px;
        border-radius: 5px;
        transition: background-color 150ms;
        transition-timing-function: linear;
    }

    #removeButton:hover {
        background-color: rgba(10, 10, 10, .2);
    }
</style>

</html>