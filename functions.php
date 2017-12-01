<?php 
    function findTask($pdo, $id)
    {
        if ($id) {
            $query = "SELECT * from tasks
                WHERE id = :id;
                ";
            $prepquery = $pdo->prepare($query);
            $prepquery->execute([
                'id' => $id,
            ]);    

            return $prepquery->fetch();
        }
        return null;
    }

    function insertTask($pdo, $descr) 
    {
        if($descr) {
            $dt = new \Datetime();
            $dt = $dt->format('Y-m-d H:i:s');

            $query = "INSERT into tasks
            VALUES(null, :descr, 0, :dt); 
                ";
            $prepquery = $pdo->prepare($query);
            $prepquery->execute([
                'descr' => $descr,
                'dt' => $dt,
            ]);
        }
    }

    function completeTask($pdo, $id) 
    {
        if ($id) {
            $query = "UPDATE tasks
                set is_done = 1
                where id = :id;
                ";
            $prepquery = $pdo->prepare($query);
            $prepquery->execute([
                'id' => $id,
            ]);        
        }            
    }

    function deleteTask($pdo, $id) 
    {
        if ($id) {
            $query = "DELETE from tasks
                WHERE id = :id;
                ";
            $prepquery = $pdo->prepare($query);
            $prepquery->execute([
                'id' => $id,
            ]);                        
        }
    }

    function updateTask($pdo, $id, $descr)
    {
        if ($id) {
            $query = "UPDATE tasks
                set description = :descr
                where id = :id;
                ";
            $prepquery = $pdo->prepare($query);
            $prepquery->execute([
                'descr' => $descr,
                'id' => $id,
            ]);            
        }
    }