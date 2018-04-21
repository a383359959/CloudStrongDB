<?php
// +----------------------------------------------------------------------
// | 数据库操作类
// +----------------------------------------------------------------------
// | 时间: 2017年3月6日
// +----------------------------------------------------------------------
// | 作者: 邱昊 <383359959@qq.com> <http://www.iuiuy.com>
// +----------------------------------------------------------------------

header('Content-type: text/html; charset=utf-8');

class CloudStrongDB{

	public $config;
	
	public $link = null;

	public $options = array(
		'YTHINK_TABLE' => '',
		'field' => '*',
		'YTHINK_WHERE' => '',
		'YTHINK_JOIN' => '',
		'YTHINK_ORDER' => '',
		'group' => '',
		'limit' => ''
	);

	public $sqls = array(
		'select' => 'SELECT field FROM YTHINK_TABLE YTHINK_JOIN YTHINK_WHERE group YTHINK_ORDER limit',
		'add'  => 'INSERT INTO YTHINK_TABLE SET options',
		'save' => 'UPDATE YTHINK_TABLE SET options YTHINK_WHERE',
		'delete' => 'DELETE FROM table where'
	);

	public $tables = array();

	public function __construct($config){
		$this->config = $config;
		$this->mysql_connect();
	}

	public function mysql_connect(){
		$host = empty($this->config['DB_PORT']) ? $this->config['DB_HOST'].':3306' : $this->config['DB_HOST'].':'.$this->config['DB_PORT'];
		$this->link = mysqli_connect($host,$this->config['DB_USER'],$this->config['DB_PASS'],$this->config['DB_NAME']);
		if(!$this->link) $this->error('对不起，数据库连接失败');
		mysqli_query($this->link,'SET NAMES UTF8');
	}

	public function check_table($name){
		$name = $this->config['DB_PREFIX'].$name;
		$sql = 'show tables';
		$query = mysqli_query($this->link,$sql);
		while($row = mysqli_fetch_assoc($query)){
			$this->tables[] = $row['Tables_in_'.$this->config['DB_NAME']];
		}
		return in_array($name,$this->tables);
	}

	public function table($name,$alias = ''){
		$this->options['YTHINK_TABLE'] = empty($name) ? '' : $this->config['DB_PREFIX'].$name;
		$check = $this->check_table($name);
		if(!$check) $this->error('对不起，'.$name.'数据库不存在');
		if(empty($this->options['YTHINK_TABLE'])) $this->error('请填写表名');
		$this->options['YTHINK_TABLE'] = '`'.$this->options['YTHINK_TABLE'].'`';
		if(!empty($alias)) $this->options['YTHINK_TABLE'] .= ' AS '.$alias;
		return $this;
	}

	public function field($string){
		$this->options['field'] = empty($string) ? '*' : $string;
		return $this;
	}

	public function join($name,$alias = '',$on = '',$type = 'LEFT'){
		if(empty($name)) $this->error('关联表名不能为空');
		if(empty($on)) $this->error('关联条件不能为空');
		$p = $this->config['DB_PREFIX'];
		$alias = empty($alias) ? $p.$name : $p.$name.' AS '.$alias;
		$on = empty($on) ? '' : ' ON '.$on;
		$this->options['YTHINK_JOIN'][] = $type.' JOIN '.$alias.$on;
		return $this;
	}

	public function where($string){
		if(!empty($string)) $this->options['YTHINK_WHERE'] = 'WHERE '.$string;
		return $this;
	}

	public function order($string){
		if(!empty($string)) $this->options['YTHINK_ORDER'] = 'ORDER BY '.$string;
		return $this;
	}

	public function group($string){
		if(!empty($string)) $this->options['group'] = 'GROUP BY '.$string;
		return $this;
	}

	public function limit($string){
		if(!empty($string)) $this->options['limit'] = 'LIMIT '.$string;
		return $this;
	}

	public function select($esql = false){
		$arr = array();
		$sql = $this->sqls['select'];
		
		foreach($this->options as $key => $value){
			if($key != 'YTHINK_JOIN'){
				$sql = str_replace($key,$value,$sql);
			}else{
				if($value){
					$join = '';
					foreach($value as $k => $v){
						$join .= $v.' ';
					}
					$sql = str_replace($key,$join,$sql);
				}else{
					$sql = str_replace($key,$join,$sql);
				}
			}
		}
		if($esql) die($sql);
		$query = mysqli_query($this->link,$sql);
		if(!$query) $this->error(mysqli_error($this->link));
		while($row = mysqli_fetch_assoc($query)){
			$arr[] = $row;
		}
		return $arr;
	}

	public function find($esql = false){
		$sql = $this->sqls['select'];
		foreach($this->options as $key => $value){
			if($key != 'join'){
				$sql = str_replace($key,$value,$sql);
			}else{
				$join = '';
				foreach($value as $k => $v){
					$join .= $v.' ';
				}
				$sql = str_replace($key,$join,$sql);
			}
		}
		if($esql) die($sql);
		return mysqli_fetch_assoc($this->query($sql));
	}

	public function add($arr,$esql = false){
		$options = $this->get_arr($arr);
		$sql = $this->sqls['add'];
		$sql = str_replace('YTHINK_TABLE',$this->options['YTHINK_TABLE'],$sql);
		$sql = str_replace('options',implode(',',$options),$sql);
		if($esql) die($sql);
		if($this->query($sql)) return mysqli_insert_id($this->link);
	}

	public function save($arr,$esql = false){
		$options = $this->get_arr($arr);
		$sql = $this->sqls['save'];
		$sql = str_replace('YTHINK_TABLE',$this->options['YTHINK_TABLE'],$sql);
		$sql = str_replace('options',implode(',',$options),$sql);
		$sql = str_replace('YTHINK_WHERE',$this->options['YTHINK_WHERE'],$sql);
		if($esql) die($sql);
		return $this->query($sql);
	}

	public function delete($esql = false){
		$sql = $this->sqls['delete'];
		$sql = str_replace('table',$this->options['table'],$sql);
		$sql = str_replace('where',$this->options['where'],$sql);
		if($esql) die($sql);
		return $this->query($sql);
	}

	public function get_arr($arr){
		$options = array();
		foreach($arr as $key => $value){
			$options[] = is_string($value) ? '`'.$key.'` = "'.$value.'"' : '`'.$key.'` = '.$value;
		}
		return $options;
	}

	public function query($sql){
		$query = mysqli_query($this->link,$sql);
		if(!$query) $this->error(mysqli_error($this->link));
		return $query;
	}

	/*
	*	这个函数可以重新写的更友好
	*/
	public function error($msg){
		die($msg);
	}

}