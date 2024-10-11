<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="vendor/picocss/pico/css/pico.min.css">
    <title>Task List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        // search func.
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("taskTable");
            let rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) { 
                let cells = rows[i].getElementsByTagName("td");
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    let cellText = cells[j].innerText.toLowerCase();
                    if (cellText.indexOf(input) > -1) {
                        found = true;
                        break;
                    }
                }

                rows[i].style.display = found ? "" : "none"; 
            }
        }
    </script>
</head>
<body>
<main class="container">
<h1>Task List</h1>

<!-- Search Box -->
<input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for tasks..">

<?php
include 'api/get_tasks.php'; 

$tasks = getTasks();

if (is_string($tasks)) {
    echo "<p>Something went wrong: $tasks</p>";
} else {
    echo "<table id='taskTable'>";
    echo "<tr>
            <th>Task</th>
            <th>Title</th>
            <th>Description</th>
            <th>Color Code</th>
          </tr>";

    foreach ($tasks as $task) {
        echo "<tr style='background-color: {$task['colorCode']} !important;'>";
        echo "<td>{$task['task']}</td>";
        echo "<td>{$task['title']}</td>";
        echo "<td>{$task['description']}</td>";
        echo "<td>{$task['colorCode']}</td>";
        echo "</tr>";
    }

    echo "</table>";
}
?>
    </main>
</body>
</html>
