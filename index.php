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
          </tr>
          <tbody>";
          
    foreach ($tasks as $task) {
        echo "<tr style='background-color: {$task['colorCode']} !important;'>";
        echo "<td>{$task['task']}</td>";
        echo "<td>{$task['title']}</td>";
        echo "<td>{$task['description']}</td>";
        echo "<td>{$task['colorCode']}</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
}
?>
    </main>
    <script src="vendor/components/jquery/jquery.min.js" type="text/javascript"></script>
    
    <script>
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

        function updateTable() {
            $.getJSON('api/get_tasks.php?refresh=true', function(data) {
                let tableBody = $('#taskTable tbody');
                tableBody.empty(); // Clear the existing table body
                
                data.forEach(task => {
                    let row = `<tr>
                        <td>${task.task}</td>
                        <td>${task.title}</td>
                        <td>${task.description}</td>
                        <td style="background-color: ${task.colorCode}">${task.colorCode}</td>
                    </tr>`;
                    tableBody.append(row);
                });
            });
        }

        // On document ready, update the table once
        $(document).ready(function() {
            updateTable();
            setInterval(function() {
                updateTable();
                console.log("refreshed");
            }, 3600000); // 3600000ms = 60 minutes
        });
    </script>
</body>
</html>
