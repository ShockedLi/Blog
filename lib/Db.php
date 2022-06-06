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

    public function update($data) {
        $sql = $this->_build_sql('update',$data);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete() {
        $sql = $this->_build_sql('delete');
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function page($page, $pageSize=10, $path='/') {
        $this->limit = ($page - 1) * $pageSize.', '.$pageSize;
        $count = $this->count();
        $data = $this->lists();
        $pages = $this->_subPages($page, $pageSize, $count, $path);
        return array('count'=>$count, 'data'=>$data, 'pages'=>$pages);
    }

    private function _subPages($cur_page, $pageSize, $total, $path) {
        //$cur_page : 当前页码
        //$pageSize : 一页最大的数据记录数量
        //$total : 记录总量

        $symbol = '?';
        if(strpos($path,'?')>0) {
            $symbol = '&';
        }

        //分页数
        $page_count=ceil($total/$pageSize);
        if($cur_page>1) {
            $html="<li><a href='{$path}{$symbol}page=1'>首页</a></li>";
            $pre_page = $cur_page-1;
            $html.= "<li><a href='{$path}{$symbol}page={$pre_page}'>上一页</a></li>";
        }
       
        $start = $cur_page > ($page_count-6) ? ($page_count-6): $cur_page;
        $start = $start - 2;
        $start = $start<=0?1:$start; //作用总页数少于6的情况
        $end = ($cur_page+6) > $page_count? $page_count:($cur_page+6);
        $end = $end - 2;
        if($cur_page+2>=$end && $page_count > 6) {
            $start = $start+2;
        }
        if(($page_count -$cur_page)<6) {
            $end = $end +2;
        }
        for($i=$start;$i<=$end;$i++) {
            $html.= $i == $cur_page?"<li class='active'><a>{$i}</a></li>":"<li><a href='{$path}{$symbol}page={$i}'>{$i}</a></li>";
        }

        if($cur_page<$page_count) {
            $after_page=$cur_page+1;
            $html.= "<li><a href='{$path}{$symbol}page={$after_page}'>下一页</a></li>";
            $html.="<li><a href='{$path}{$symbol}page={$page_count}'>尾页</a></li>";
        }
        

        $html='<nav aria-label="Page navigation"><ul class="pagination">'.$html.'</li></ul>';
        return $html;
    }

    public function count() {
        $sql = $this->_build_sql('count');
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $total = $stmt->fetchColumn(0);
        return $total;
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
    
            if($this->limit) {
                $sql .= " limit {$this->limit}";
            }
            //exit($sql);
        }

        if($type == 'count') {
            $where = $this->_build_where();
            $field_list = explode(',',$this->field);
            $field = count($field_list)>1? '*':$this->field;
            $sql = "select count({$field}) from {$this->table} {$where}";
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
        if($type == 'delete') {
            $where = $this->_build_where();
            $sql = "delete from {$this->table} {$where}";
            //exit($sql);
        }
        if($type == 'update') {
            $where = $this->_build_where();
            $str = '';
            foreach($data as $key => $val) {
                $val = is_string($val)? "'".$val."'" : $val;
                $str .= "{$key}={$val},";
            }
            $str = rtrim($str,',');
            $str = $str? " set {$str}" : '';
            $sql = "update {$this->table} {$str} {$where}";
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