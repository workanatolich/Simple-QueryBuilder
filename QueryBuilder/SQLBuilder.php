<?php

class SQLBuilder {

    public function make_sql($action, $table, $data=null, $id=null, $params=null) {
        $action = strtolower($action);
        
        if($action == 'select') {
            $sql = $this->create_sql_select($table, $id, $params);
        }

        if($action == 'insert') {
            $sql = $this->create_sql_insert($table, $data);
        }

        if($action == 'update') {
            $sql = $this->create_sql_update($table, $data);
        }

        if($action == 'delete') {
            $sql = $this->create_sql_delete($table);
        }

        return $sql;
    }

    private function create_sql_select($table, $id=null, $params=null) {
        
        if(!empty($params) && is_array($params)) {
            $keys = implode(',', array_values($params));
        } else {          
            $keys = '*';
        }

        if(isset($id)) {
            $sql = "SELECT {$keys} FROM {$table} WHERE id=:id";
        } else {
            $sql = "SELECT {$keys} FROM {$table}";
        }

        return $sql; 
    }

    private function create_sql_insert($table, $data) {
        $keys = implode(',', array_keys($data));
        $tags = ':' .implode(',:', array_keys($data));

        $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$tags})";

        return $sql;
    }

    private function create_sql_update($table, $data) {
        $keys = array_keys($data);
        $expression = '';

        foreach($keys as $key) {
            $expression .= $key .'=:' .$key .',';
        }

        $expression = rtrim($expression, ',');

        $sql = "UPDATE {$table} SET {$expression} WHERE id=:id";

        return $sql;
    }

    private function create_sql_delete($table) {
        $sql = "DELETE FROM {$table} WHERE id=:id";
        return $sql;
    }

}
