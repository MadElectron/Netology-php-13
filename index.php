<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Task Manager</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php 
        require_once 'functions.php';

        // Home database
        $host = 'localhost';
        $dbname = 'netology';
        $user = 'root';
        $pass = 'BJz5c8PI'; 
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
        ];

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $pdo = new PDO($dsn, $user, $pass, $options);

        $descr = $_POST['description'] ?? '';
        $doneId = $_POST['done'] ?? '';
        $deleteId = $_POST['delete'] ?? '';
        $editId = $_POST['editId'] ?? '';

        if($descr) {
            if($editId) {
                updateTask($pdo, $editId, $descr);
            } else {
                insertTask($pdo, $descr);
            }
        } 
        if($doneId) {
            completeTask($pdo, $doneId);
        }
        if($deleteId) {
            deleteTask($pdo, $deleteId);
        }

        $column = $_POST['column'] ?? 'id';
        $query = "SELECT * from tasks
            ORDER BY $column;
            ";
        $prepquery = $pdo->prepare($query);
        $prepquery->execute();
        $queryResult = $prepquery->fetchAll();
    ?>
    <div class="container">
        <h1>Task Manager</h1>

        <form action="" method="post" accept-charset="utf-8">
            
            <?php if($_POST['edit'] ?? '') : ?>
                <?php $editRow = findTask($pdo, $_POST['edit']); ?>
                <input type="text" name="description" value="<?php echo $editRow['description']; ?>" placeholder="Название" autofocus>
                <input type="hidden" name="editId" value="<?php echo $_POST['edit']; ?>">
                <input type="submit" name="submit" value="Изменить">
            <?php else : ?>
                <input type="text" name="description" value="<?php echo $_POST['name'] ?? ''; ?>" placeholder="Название">
                <input type="submit" name="submit" value="Добавить">
            <?php endif; ?>
        </form>

        <table>
            <thead>
                <tr>
                    <th>№ п/п</th>
                    <th>ID задачи</th>
                    <th>
                        Описание задачи
                        <form action="" method="post" accept-charset="utf-8">
                            <input type="hidden" name="column" value="<?php echo (($_POST['column'] ?? '') == 'description asc' ? 'description desc' : 'description asc') ?>">
                            <button class="filter" type="submit" value="sort">
                                <?php echo (($_POST['column'] ?? '') == 'description asc' ? '&#x25BC;' : '&#x25B2;') ?>
                            <button class="filter" type="submit" value="sort" ?>
                            </button>
                        </form>
                    </th>
                    <th>
                        Дата добавления
                        <form action="" method="post" accept-charset="utf-8">
                            <input type="hidden" name="column" value="<?php echo (($_POST['column'] ?? '') == 'date_added asc' ? 'date_added desc' : 'date_added asc') ?>">
                            <button class="filter" type="submit" value="sort">
                                <?php echo (($_POST['column'] ?? '') == 'date_added asc' ? '&#x25BC;' : '&#x25B2;') ?>
                            </button>
                        </form>

                    </th>
                    <th>
                        Статус
                        <form action="" method="post" accept-charset="utf-8">
                            <input type="hidden" name="column" value="<?php echo (($_POST['column'] ?? '') == 'is_done asc' ? 'is_done desc' : 'is_done asc') ?>">
                            <button class="filter" type="submit" value="sort">
                                <?php echo (($_POST['column'] ?? '') == 'is_done asc' ? '&#x25BC;' : '&#x25B2;') ?>
                            </button>
                        </form>                        
                    </th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
            <?php  if ($queryResult) : ?>
                <?php foreach($queryResult as $index => $row) : ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['date_added']; ?></td>
                        <?php echo $row['is_done'] ? '<td class="task-done">Выполнено</td>': '<td class="task-progress">В процессе</td>'; ?>
                        <td>
                            <form action="" method="post" accept-charset="utf-8">
                                <button type="submit" name="done" value="<?php echo $row['id'];  ?>" <?php echo $row['is_done'] ? 'disabled' : '' ?>>
                                    Выполнить
                                </button>
                            </form>
                            <form action="" method="post" accept-charset="utf-8">
                                <button type="submit" name="edit" value="<?php echo $row['id'];  ?>">
                                    Изменить
                                </button>
                            </form>                            
                            <form action="" method="post" accept-charset="utf-8">
                                <button type="submit" name="delete" value="<?php echo $row['id'];  ?>" onclick="confirm('Вы действительно хотите удалить задание &laquo;<?php echo $row['description']; ?>&raquo;')">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table> 

    </div>
</body>
</html>

