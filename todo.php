<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/b1fed987ee.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
            </div>
            <div class="col-10 col-lg-8">
                <div class="row pb-3" id="header">
                    <h1 class="display-1 text-center">PHP/MySQL Test Project</h1>
                    <h5 class="display-5 text-center"><small class="text-muted">A PHP-HTML demo page with get, insert, and delete to MySQL database with AJAX</small></h5>
                    <p class="text-center text-muted">Ft. Bootstrap, JQuery, and Fontawesome Icons</p>
                </div>
                <div class="row" id="divTable">

                    <div class="col">
                        You have <b id="todoCount">0</b> thing(s) to do
                    </div>

                    <table id="todoTable" class="table py-3">
                        <thead>
                            <tr>
                                <th style="width: 5%;"></th>
                                <th style="width: 60%;">What to do</th>
                                <th style="width: 35%;">Deadline</th>
                            </tr>
                        </thead>
                        <tbody id="todoTableBody">

                        </tbody>
                    </table>
                </div>
                <div class="row" id="divForm">
                    <form id="todoForm" onsubmit="setAction(this); return false;" data-action="add">
                        To do: <input type="text" name="toDo" required class="form-control">
                        When: <input type="date" name="when" required class="form-control">
                        <div class="text-end">
                            <input type="submit" value="Add" class="btn btn-primary my-2 px-4">
                        </div>
                    </form>
                    <div id="status">
                        stat
                    </div>
                    <button id="debug">The debug button</button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="confirmationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel">Confirm action</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p id="modalText">

                                </p>
                                <p id="rowData">

                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button id="confirmActionButton" type="button" onclick="confirmAction(this)" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col">
            </div>
        </div>
    </div>


</body>

<script>
    function confirmAction(r) {
        var action = r.getAttribute("data-action");
        switch (action) {
            case "add":
                var form = document.querySelector('form');
                alert("add");
                alert(form)
                formSubmit(form);
                break;
            case "remove":
                var i = r.getAttribute("data-row-id");
                $.ajax({
                    method: "POST",
                    url: "dbActions.php",
                    data: {
                        intent: "remove",
                        id: i,
                    },
                    complete: function(event) {
                        $("#status").html(event.responseText);
                        getTable();
                    }
                });
                break;
        }
    };

    function setAction(r) {
        var action = r.getAttribute("data-action");
        switch (action) {
            case "add":
                var todo = r.toDo.value;
                var deadline = r.when.value;
                break;
            case "remove":
                var id = r.getAttribute("data-row-id");
                var todo = r.getAttribute("data-row-todo");
                var deadline = r.getAttribute("data-row-deadline");

                document.getElementById("confirmActionButton").setAttribute("data-row-id", id);
                break;
        }
        // Also show modal
        $("#confirmationModal").modal("show");

        document.getElementById("confirmActionButton").setAttribute("data-action", action);
        document.getElementById("modalText").innerHTML = "Are you sure you want to " + action + "?";
        document.getElementById("rowData").innerHTML = todo + " - " + deadline

    };

    function formSubmit(form) {
        var todo = form.toDo.value;
        var deadline = form.when.value;
        $.ajax({
            method: "POST",
            url: "dbActions.php",
            data: {
                intent: "add",
                todo: todo,
                deadline: deadline
            },
            complete: function(event) {
                $("#status").html(event.responseText);
                getTable();
            }
        });
    };

    function getTable() {
        console.log("gettable");
        $("#todoTableBody").load("dbActions.php", {
            intent: "getTable"
        }, function() {
            $("#todoCount").html($("#todoTable tr").length - 1);
        });
    };

    $(document).ready(function() {
        getTable();
    });

    $("#debug").click(function() {
        $("#status").html()
    });
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

    #divTable {
        animation: fadeInAnimation ease-in 1000ms, slideAnimation ease 1000ms;
        animation-fill-mode: forwards;
        z-index: -1;
    }

    @keyframes slideAnimation {
        0% {
            margin-top: -20%;
        }

        100% {
            margin-top: 0%;
        }
    }
    #divForm {
        animation: fadeInAnimation ease-in 1500ms;
        animation-fill-mode: forwards;
        z-index: -1;
    }

    @keyframes fadeInAnimation {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }
</style>

</html>