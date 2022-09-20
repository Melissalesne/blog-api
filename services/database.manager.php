<?php 


class DatabaseManager 
{

    public function __construct($table)
    {
        $this->table = $table;
    }


    public function selectOne($id){
        $sql = "SELECT * FROM $this->table WHERE is_deleted = ? AND Id_$this->table = ?";
        $resp = $this->query($sql, [0, $id]);
        $rows = $resp->statment->fetchAll(PDO::FETCH_CLASS);
        $row = $resp->result && count($rows) == 1 ? $rows[0] : null;
        return $row;
    }
}