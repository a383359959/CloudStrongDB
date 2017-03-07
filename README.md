# CloudStrongDB

数据库操作类

# 使用方法

```php
/*
*	可以像ThinkPHP那样做成函数调用
*	@param $table string 表名称
*	@param $alias string 别名，多用于关联表
*	@return object 返回模型实例
*/
function M($table,$alias = ''){
	$_CFG = array(
		'DB_HOST' => 'localhost',
		'DB_PORT' => 3306,
		'DB_USER' => 'root',
		'DB_PASS' => 'root',
		'DB_PREFIX' => 'ecs_',
		'DB_NAME' => 'b2b2'
	);
	$model = new CloudStrongDB($_CFG);
	return $model->table($table,$alias);
}
```

# 连贯方法

连贯操作|用法|参数|返回值
-------------|-------------|-------------|-------------
table|table($name,$alias = '')|name（必须）：数据表名称</br>alias（可选）：表的别名|当前模型实例
field|field($string = '')|string（可选）：字段名称|当前模型实例
where|where($string = '')|string（可选）：搜索条件|当前模型实例
join|join($name,$alias = '',$on = '')|name（必须）：关联表名称</br>alias（可选）：表的别名</br>on（可选）：关联条件|当前模型实例
order|order($string = '')|string（可选）：排序|当前模型实例
group|group($string = '')|string（可选）：分组|当前模型实例
limit|limit($string = '')|string（可选）：限制数量|当前模型实例

# CURD操作

连贯操作|用法|参数|返回值
-------------|-------------|-------------|-------------
select|select($esql = false)|$esql（可选）：如果为true输出SQL语句|二维索引数组
find|find($esql = false)|$esql（可选）：如果为true输出SQL语句|索引数组
add|add($arr,$esql = false)|arr（必须）：要新增的数据，仅支持数组<br>esql（可选）：如果为true输出SQL语句|自增ID
save|save($arr,$esql = false)|arr（必须）：需要修改的数据，仅支持数组</br>esql（可选）：如果为true输出SQL语句|返回资源id
delete|delete($esql = false)|$esql（可选）：如果为true输出SQL语句|返回资源id

# 举例

```php
// 返回一位数组
$find = M('users')->where('id = 1')->find();

// 返回二维数组
$list = M('users')->order('id desc')->select();

// 多表联查
$list = M('users','a')->field('username')->join('users_store','b','a.userid = b.userid')->join('users_name','c','c.userid = b.userid')->select();

// 增
$data['username'] = 'admin';
$data['password'] = md5('admin');
M('admin')->add($data);

// 删
M('admin')->where('id = 1')->delete();

// 改
$data['username'] = 'admin';
$data['password'] = md5('admin');
M('admin')->where('id = 1')->save($data);

// 调试输出SQL语句
$data['username'] = 'admin';
$data['password'] = md5('admin');
M('admin')->where('id = 1')->save($data,true);

/*
*	可以像ThinkPHP那样做成函数调用
*	@param $table string 表名称
*	@param $alias string 别名，多用于关联表
*	@return object 返回模型实例
*/
function M($table,$alias = ''){
	$_CFG = array(
		'DB_HOST' => 'localhost',
		'DB_PORT' => 3306,
		'DB_USER' => 'root',
		'DB_PASS' => 'root',
		'DB_PREFIX' => 'ecs_',
		'DB_NAME' => 'b2b2'
	);
	$model = new CloudStrongDB($_CFG);
	return $model->table($table,$alias);
}
```

# 关于

作者：邱昊

企鹅：383359959

邮箱：383359959@qq.com

公司：沈阳云壮网络科技有限公司

官方网站：http://www.iuiuy.com/

技术交流：http://tieba.iuiuy.com/