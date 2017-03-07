# Upload

上传图片PHP版服务端

# 使用方法

```html
<form action="upload.php" name="form" method="post" enctype="multipart/form-data">

    <input type="file" name="file" />
  
    <input type="submit" name="submit" value="上传" />
  
</form>
```

```php
$upload = new \YThink\Upload();
	
/*
*	定义保存路径
*/
$upload->savePath = dirname(__FILE__).'/Uploads';
	
/*
*   设置图片宽，留空则保持原尺寸
*/
$upload->imgWidth = 100;
	
/*
*   设置图片高，留空则保持原尺寸
*/
$upload->imgHeight = 100;

/*
*   上传文件按钮name名
*/
$upload->name = 'file';

/*
*	是否创建日期文件夹
*	默认：true
*	如果为true则在保存路径里自动创建”YYYY-MM-DD“的文件夹
*/
$upload->is_date = false;

/*
*	返回路径
*	如果空则直接返回文件名称，不为空则返回/upload/user/文件.jpg
*/
$upload->file_path = '/upload/user/';
	
/*
*   执行上传操作
*/
$info = $upload->upload();
	
/*
*   打印查看输出结果
*/
var_dump($info);
```

# 关于

作者：邱昊

企鹅：383359959

邮箱：383359959@qq.com

公司：沈阳云壮网络科技有限公司

官方网站：http://www.iuiuy.com/

技术交流：http://tieba.iuiuy.com/