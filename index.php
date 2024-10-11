<?php
// index.php

include 'api/get_tasks.php'; // include get_tasks.php to get data

$tasks = getTasks(); // get data

if (is_string($tasks)) {
    echo "<p>An error occurred while retrieving data: $tasks</p>";
} else {
    header('Content-Type: application/json'); 
    echo json_encode($tasks, JSON_PRETTY_PRINT); 
    
    /*
    echo "<table border='1'>";
    echo "<tr>
            <th>Task</th>
            <th>Title</th>
            <th>Description</th>
            <th>Color Code</th>
          </tr>";

    // put data into table
    foreach ($tasks as $task) {
        echo "<tr style='background-color: {$task['colorCode']}'>";
        echo "<td>{$task['task']}</td>";
        echo "<td>{$task['title']}</td>";
        echo "<td>{$task['description']}</td>";
        echo "<td>{$task['colorCode']}</td>";
        echo "</tr>";
    }

    echo "</table>"; */
}
?>
