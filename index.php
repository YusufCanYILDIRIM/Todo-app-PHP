<?php

// hata zamanlarıda olacaklar
$errors = "";



// database bağlantısı yapma
$db = mysqli_connect('localhost', 'root', '', 'todo');
// $db = new mysqli('localhost', 'root', '', 'todo');

if (isset($_POST['submit'])) {
    $task = $db -> real_escape_string($_POST['task']); //içeri alınabilecek bir öge yazmayı saglar.
    if (empty($task)) {
        $_SESSION ['mesaj'] =  "Bir görev giriniz";
        $errors = $_SESSION['mesaj'];
    } else {
        mysqli_query($db, "INSERT INTO tasks (task) VALUES ('$task')");
        // $db -> query("INSERT INTO tasks (task) VALUES ('$task')");
        header('location: index.php');
    }
}

$tasks = mysqli_query($db, "SELECT * FROM tasks");
// $tasks = $db -> query("SELECT * FROM tasks");

// delete
if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];
    mysqli_query($db, "DELETE FROM tasks WHERE id =$id");
    header('location: index.php');
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Php - Todo List Proje</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="heading">
        <h2>Todo List Proje</h2>
    </div>

    <!-- form oluşturdum -->
    <form action="index.php" method="POST">
        <?php 
            if (isset($errors)) { ?>
            <p><?php echo $errors; ?></p>
        <?php } ?>
        
        <input type="text" name="task" class="task_input">
        <button type="submit" class="add_btn" name="submit">add Task</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>N</th>
                <th>Task</th>
                <th>action</th>
            </tr>
        </thead>

        <tbody>
            <?php $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td class="task"><?php echo $row['task']; ?></td>
                    <td class="delete">
                        <a href="index.php?del_task=<?php echo $row['id']; ?>">x</a>
                    </td>
                </tr>
            <?php $i++; } ?>

        </tbody>
    </table>
</body>

</html>