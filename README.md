# thinkphp6 华为云 filesystem

基于 [dscmall/laravel-filesystem-obs](https://github.com/dscmall/laravel-filesystem-obs) 轻度封装tp
## 安装

---
```shell
composer require death_satan/thinkphp-huawei-obs
```
---

## 初始化
### 修改配置 *config/filesystem.php* 文件

---
```php
<?php

return [
    // 默认磁盘
    'default' => env('filesystem.driver', 'local'),
    // 磁盘列表
    'disks'   => [
        'local'  => [
            'type' => 'local',
            'root' => app()->getRuntimePath() . 'storage',
        ],
        'public' => [
            // 磁盘类型
            'type'       => 'local',
            // 磁盘路径
            'root'       => app()->getRootPath() . 'public/storage',
            // 磁盘路径对应的外部URL路径
            'url'        => '/storage',
            // 可见性
            'visibility' => 'public',
        ],
        //新增一个磁盘
        'huawei'=>[
           'type'            => 'Huawei',//设置驱动
           'key' => env('OBS_ACCESS_ID'), // <Your Huawei OBS AccessKeyId>
           'secret' => env('OBS_ACCESS_KEY'), // <Your Huawei OBS AccessKeySecret>
           'bucket' => env('OBS_BUCKET'), // <OBS bucket name>
           'endpoint' => env('OBS_ENDPOINT'), // <the endpoint of OBS, E.g: (https:// or http://).obs.cn-east-2.myhuaweicloud.com | custom domain, E.g:img.abc.com> OBS 外网节点或自定义外部域名
           'cdn_domain' => env('OBS_CDN_DOMAIN'), //<CDN domain, cdn域名> 如果isCName为true, getUrl会判断cdnDomain是否设定来决定返回的url，如果cdnDomain未设置，则使用endpoint来生成url，否则使用cdn
           'ssl_verify' => env('OBS_SSL_VERIFY'), // <true|false> true to use 'https://' and false to use 'http://'. default is false,
           'debug' => env('APP_DEBUG'), // <true|false>
           'prefix'=>'',//prefix
        ]
        // 更多的磁盘配置信息
    ],
];

```
---

## 使用方法
### 通过filesystem使用

---
```php 
//通过门面使用
think\facade\Filesystem::disk('huawei')
//在控制器中通过注入使用
class TestControl{

    public function Test(\think\Filesystem $filesystem)
    {
        $aliyun = $filesystem->disk('huawei');
    }
}
```
---

### 文件上传

```php 
<?php
namespace app\controller;

use app\BaseController;
use app\Request;
use think\facade\Filesystem;

class Index extends BaseController
{
    public function index(Request $request)
    {
        //获取上传文件
        $file = $request->file('image');
        //通过filesystem进行上传
        $url = Filesystem::disk('huawei')->putFile('images', $file);
        if (!$url) new \exception('上传失败');

        dd('上传成功,文件位置:' . $url);
    }
}
```