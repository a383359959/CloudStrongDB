# CloudStrongDB

数据库操作类

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

# 关于

作者：邱昊

企鹅：383359959

邮箱：383359959@qq.com

公司：沈阳云壮网络科技有限公司

官方网站：http://www.iuiuy.com/

技术交流：http://tieba.iuiuy.com/