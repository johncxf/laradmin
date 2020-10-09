## Laradmin

基于laravel5.8进行开发

### 环境

#### laravel环境要求

- PHP >= 7.1.3
- PHP OpenSSL 扩展
- PHP PDO 扩展
- PHP Mbstring 扩展
- PHP Tokenizer 扩展
- PHP XML 扩展
- PHP Ctype 扩展
- PHP JSON 扩展

#### 开发要求

- composer
- nginx或者apache
- mysql5.7+
- php7.0+
- nmp（选择性安装）

### 安装

#### 基本安装

##### 拉取代码

```
git clone git地址
```

##### composer依赖

```
composer install
```

安装完成会在根目录生成`vendor`目录

需要修改composer安装包的内容可以在`composer.json`修改，修改后执行composer更新操作即可

```
composer update
```

##### 创建并配置`.env`文件

复制`.env.example`文件为`.env`

```
cp .env.example .env
```

生成`APP_KEY`

自己创建的`.env`文件中的`APP_KEY`为空，需要执行命令生成

```
php artisan key:generate
```

#### 数据库

##### 创建数据库

建议：在自己的环境创建数据库`laradmin`，字符集为： `utf8mb4_unicode_ci `，数据库引擎：`InnoDB`

##### 配置数据库连接

修改`.env`文件的数据库配置为本地数据库的配置

```
# 主数据库
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laradmin
DB_USERNAME=root
DB_PASSWORD=root

# laradmin数据库，项目中现在使用这个数据库配置
DB_HOST_LARADMIN=127.0.0.1
DB_PORT_LARADMIN=3306
DB_DATABASE_LARADMIN=laradmin
DB_USERNAME_LARADMIN=root
DB_PASSWORD_LARADMIN=root
```

具体的配置可以自己修改`config/database.php`文件

##### 生成数据库

```
php artisan migrate:refresh
```

##### 数据填充

```
php artisan db:seed
```

### 其他

#### 数据库版本过低

laravel要求msql环境为5.7.7以上版本，如果本地开发环境mysql版本未达到要求，需要在`App\Providers\AppServiceProvider.php`文件配置

```php
public function boot()
{
    // mysql版本低于5.7.7
    \Schema::defaultStringLength(191);
}
```

#### npm安装前端组件

```
npm install
```

安装后会在根目录生成`node_modules`目录

需要更改npm安装的内容可以在`package.json`文件进行修改，修改后执行更新操作

```
npm update
```

**注：可以跳过，有开发需要再安装**

### 扩展

#### 后端使用扩展

| 扩展包               | 简介                 | 应用场景               |
| -------------------- | -------------------- | ---------------------- |
| caouecs/laravel-lang | 语言包，composer安装 | 使用了其中的中文语言包 |
| mews/captcha         | 验证码               | 登录验证码             |
| ...                  |                      |                        |

#### 前端使用扩展或插件

| 扩展包           | 简介               | 应用场景           |
| ---------------- | ------------------ | ------------------ |
| admin-lte        | 后台管理主要UI框架 | 后台管理主要UI框架 |
| bootstrap        | 前端框架           | 后台管理           |
| jquery           | js框架             | 整个项目           |
| treeTable        | jquery插件         | 树形菜单前端展示   |
| ajaxFrom         | jquery插件         | ajax表单提交       |
| airDialog        | jquery插件         | 提示弹出框         |
| jquery-pjax      | jquery插件         | 后台菜单           |
| lrz              | 前端图片压缩       | 图片上传           |
| summernote       | 富文本编译器       | 撰写文章           |
| swiper           | 轮播图             | 前台首页           |
| toastr           | 提示弹窗           | 后台所有提示       |
| fontawesome-free | 图标库             | 图标库             |
| icheck-bootstrap | 复选框             | 复选框             |

### 说明

其余相关文档可以参考`doc`目录
