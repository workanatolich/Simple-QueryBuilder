<?php

class QueryBuider {
    private $pdo;
    private $sql_builder;

    public function __construct(PDO $pdo, SQLBuilder $sql_builder) 
    {
        $this->pdo = $pdo;
        $this->sql_builder = $sql_builder;

    }

    // Interface
    public function get_one(string $table, $id){
        return $this->build_query('select', $table, null, $id);
    } 
    
    public function get_all(string $table) {
        return $this->build_query('select', $table);
    }

    public function get_params_by_id(string $table, array $params, $id) {
        return $this->build_query('select', $table, null, $id, $params);
    }

    public function add(string $table, array $data) {
        return $this->build_query('insert', $table, $data);
    }

    public function update(string $table, array $data, $id) {
        return $this->build_query('update', $table, $data, $id);
    }

    public function delete(string $table, $id) {
        return $this->build_query('delete', $table, null, $id);
    }



    // Logic
    private function build_query($action, $table, $data=null, $id=null, $params=null) {
        $sql = $this->sql_builder->make_sql($action, $table, $data, $id, $params);
        $statement = $this->prepare_and_execute($sql, $data, $id, $params);
        $result = $this->display_query($action, $statement, $id);
        return $result;
    }

    private function prepare_and_execute($sql, $data, $id) {

        $statement = $this -> pdo -> prepare($sql);
        if(empty($data) && empty($id)) {
            if($statement -> execute()) {return $statement;}
        } 

        elseif(!empty($data) && empty($id)) {
            if($statement -> execute($data)) {return $statement;}
        }

        else {
            $data['id'] = $id;
            if($statement -> execute($data)) {return $statement;}
        }
        
        return false;
    }

    private function display_query($action, $statement, $id=null) {
        if($statement) {
            if($action == 'select') {
                if(isset($id)) {
                    $result = $statement -> fetch(PDO::FETCH_ASSOC);
                    return $result;
                } else {
                    $result = $statement -> fetchAll(PDO::FETCH_ASSOC);
                    return $result;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }



}