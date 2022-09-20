<?php 

class DatabaseController 
{
    public function __construct($params)
    {
        $id = array_shift($params);
        $this->action = null;

        if(isset($id) && !ctype_digit($id)){
            return $this;
        }

        $request_body = file_get_contents('php://input');
        $this->body = $request_body ? json_decode($request_body, true) : null;

        $this->table = lcfirst(str_replace("controller", "", get_called_class()));

        if($_SERVER['REQUEST_METHOD'] == "GET" && !isset($id)){ // REQUEST_METHOD:requette utilisé pour accéder à la pages ex: get,put,delete...
            $this->action = $this->getAll();
        }

        if($_SERVER['REQUEST_METHOD'] == "GET" && isset($id)){
            $this->action = $this->getOne($id);
        }
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $this->action = $this->create();
        }
        if($_SERVER['REQUEST_METHOD'] == "PUT" && isset($id)){
            $this->action = $this->update($id);
        }
        if($_SERVER['REQUEST_METHOD'] == "PATCH" && isset($id)){
            $this->action = $this->softDelete($id);
        }
        if($_SERVER['REQUEST_METHOD'] == "DELETE" && isset($id)){
            $this->action = $this->hardDelete($id);
        }


        
    }
    public function getAll(){
        $dbs = new DatabaseService($this->table);
        $rows = $dbs->selectAll();
        return $rows; //"Select all rows from table tag";

    }

    public function getOne($id){
        $dbs = new DatabaseService($this->table);
        $row = $dbs->selectOne($id);
        return $row; //"Select row with id = $id from table tag";
    }
    public function create($id){
        $dbs = new DatabaseService($this->table);
        $row = $dbs->selectOne($id);
        return $row;
        // return "Insert a new row in table theme with values : ". // Insert une nouvelle ligne dans la table theme avec pour valeur
        // urldecode(http_buil_query($this->body, '', ', ')); // décode une chaîne encodé
    }
    public function update($id){
        $dbs = new DatabaseService($this->table);
        $row = $dbs->selectOne($id);
        return row;
        // return "Update row with id = $id in table theme with values : ". // Modifie la ligne avec l'id
        // urldecode(http_build_query($this->body, '', ', '));
    }
    public function softDelete($id){
        $dbs = new DatabaseService($this->table);
        $row = $dbs->selectOne($id);
        return row;
        // return "Delete (soft) row with id = $id in table tag";
    }
    public function hardDelete($id){
        $dbs = new DatabaseService($this->table);
        $row = $dbs->selectOne($id);
        return $row;
        // return "Delete (hard) row with id = $id in table tag";
    }

  

}

?>