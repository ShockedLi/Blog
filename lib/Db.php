<?php

class Db {

    private $pdo = null;
    private $table = null;
    private $where = array();
    private $order = '';
    private $limit = 0;
    private $field = '*';

    public function __construct() {
        $dsn = 'mysql:host=192.168.0.110; dbname=myblog';
        $username = 'root';
        $password = 'root';
        $this->pdo = new PDO($dsn, $username, $password);
        $this->pdo->query("set names utf8");
    }

    public function table($table) {
        //echo $table;
        $this->table = $table;
        return $this;
    }

    public function field($field) {
        $this->field = $field;
        return $this;
    }

    public function where($where) {
        $this->where = $where;
        return $this;
    }

    public function order($order) {
        $this->order = $order;
        return $this;
    }

    public function limit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function insert($data) {
        $sql = $this->_build_sql('insert',$data);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    

    public function item() {
        $sql = $this->_build_sql('select').'limit 1';
        // exit($sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return isset($rows)? $rows[0] : false;
    }

    public function lists() {
        $sql = $this->_build_sql('select');
        // exit($sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;   
    }

    private function _build_sql($type,$data=null) {
        if($type == 'select') {
            $where = $this->_build_where();
            $sql = "select {$this->field} from {$this->table} {$where}";
            if($this->order) {
                $sql .= " order by {$this->order}";
            }
    
            if($this->limit > 0) {
                $sql .= " limit {$this->limit}";
            }
            //exit($sql);
        }
        if($type == 'insert') {
            $sql = "insert into {$this->table}";
            $fields = $values = [];
            foreach($data as $key => $val) {
                $fields[] = $key;
                $values[] = is_string($val)? "'".$val."'" : $val;
            }
            $sql .= "(".implode(',',$fields).") values(".implode(',', $values).")";
            //exit($sql);
        }
        return $sql;
    }

    private function _build_where() {
        $where = '';
        if(is_array($this->where)) {
            foreach($this->where as $key => $value) {
                $value = is_string($value)? "'".$value."'" : $value;
                $where .= "`{$key}`={$value} and ";
            }
        } else{
            //传入的是字符串，则进行以下操作
            $where = $this->where;
        }
        
        $where = rtrim($where, 'and ');
        $where = $where == ''? $where : "where {$where}";
        // exit($where);
        return $where;
    }
}
?>