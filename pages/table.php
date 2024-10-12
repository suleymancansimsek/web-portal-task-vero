<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <script src="../vendor/components/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <title>Task List</title>
</head>
<body>
<?php include '../includes/header.php'; ?>

<main class="container">

<h1>Task List</h1>

<?php
include '../api/get_tasks.php'; 

$tasks = getTasks();

if (is_string($tasks)) {
    echo "<p>Something went wrong: $tasks</p>";
} else {
    echo "<table id='taskTable' class='display cell-border'>";
    echo "<thead>
            <tr>
                <th>Task</th>
                <th>Title</th>
                <th>Description</th>
                <th>Color Code</th>
            </tr>
          </thead>
          <tbody>";
          
    foreach ($tasks as $task) {
        echo "<tr>";
        echo "<td>{$task['task']}</td>";
        echo "<td>{$task['title']}</td>";
        echo "<td>{$task['description']}</td>";
        echo "<td style='background-color: {$task['colorCode']} !important;'>{$task['colorCode']}</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
}
?>
    </main>
    <?php include '../includes/footer.php'; ?>
    <script>
        function updateTable() {
            $.getJSON('../api/get_tasks.php?refresh=true', function(data) {
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
                
                // Re-initialize DataTable after updating the table
                $('#taskTable').DataTable().destroy(); // Destroy the existing instance
                $('#taskTable').DataTable(); // Re-initialize
            });
        }

        // On document ready, initialize the DataTable
        $(document).ready(function() {
            $('#taskTable').DataTable(); // Initialize DataTables
            updateTable();
            setInterval(function() {
                updateTable();
                console.log("refreshed");
            }, 3600000); // 3600000ms = 60 minutes
        });
    </script>
</body>
</html>
