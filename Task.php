<?php 

class Task {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;

    }

    public function findAllOrderBy($column)
    {
        $query = "SELECT * from tasks
            ORDER BY $column;
            ";
        $prepquery = $this->pdo->prepare($query);
        $prepquery->execute();

        return $prepquery->fetchAll();
    }

    public function findTask($id)
    {
        if ($id) {
            $query = "SELECT * from tasks
                WHERE id = :id;
                ";
            $prepquery = $this->pdo->prepare($query);
            $prepquery->execute([
                'id' => $id,
            ]);    

            return $prepquery->fetch();
        }
        return null;
    }

    public function insertTask($descr) 
    {
        if($descr) {
            $dt = new \Datetime();
            $dt = $dt->format('Y-m-d H:i:s');

            $query = "INSERT into tasks
            VALUES(null, :descr, 0, :dt); 
                ";
            $prepquery = $this->pdo->prepare($query);
            $prepquery->execute([
                'descr' => $descr,
                'dt' => $dt,
            ]);
        }
    }

    public function completeTask($id) 
    {
        if ($id) {
            $query = "UPDATE tasks
                set is_done = 1
                where id = :id;
                ";
            $prepquery = $this->pdo->prepare($query);
            $prepquery->execute([
                'id' => $id,
            ]);        
        }            
    }

    public function deleteTask($id) 
    {
        if ($id) {
            $query = "DELETE from tasks
                WHERE id = :id;
                ";
            $prepquery = $this->pdo->prepare($query);
            $prepquery->execute([
                'id' => $id,
            ]);                        
        }
    }

    public function updateTask($id, $descr)
    {
        if ($id) {
            $query = "UPDATE tasks
                set description = :descr
                where id = :id;
                ";
            $prepquery = $this->pdo->prepare($query);
            $prepquery->execute([
                'descr' => $descr,
                'id' => $id,
            ]);            
        }
    }
}   