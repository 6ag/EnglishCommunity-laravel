# English Community Self Background Management System

Based laravel 5.2 framework, interfaces safe to use `jwt` (json web token), for video data management background, and provides an interface to the app api calls. Video tutorial module, grammar manual module, the user module, the community module.

![image](https://github.com/6ag/EnglishCommunity-laravel/blob/master/githubimg/example1.png)

![image](https://github.com/6ag/EnglishCommunity-laravel/blob/master/githubimg/example2.png)

## USEFUL LINK

- swift-app https://github.com/6ag/EnglishCommunity-swift
- json-web-token(jwt) https://github.com/tymondesigns/jwt-auth
- intervention-image https://github.com/Intervention/image
- 	apidoc http://apidocjs.com
- online api documentation http://english.6ag.cn/apidoc


## Requirements

- Nginx 1.8+ / Apache 2.2+
- PHP 5.6+
- Mysql 5.7+
- fileinfo Extension

## Installation & Homestead

**1.Cloning into the local project**

```shell
git clone https://github.com/6ag/EnglishCommunity-laravel.git
```

**2.Build homestead website**

Use homestead New Site, and parse `public` domain name to the project directory. First, enter the virtual machine environment, the new site:

* Note: * This is the path to the directory to write their own installation, and ultimately resolve to `public` directory can be, do not forget to modify the local` hosts` file and restart `nginx`.

```shell
serve www.english.com /home/vagrant/Code/EnglishCommunity-laravel/public
```

**3.Setup project dependencies**

```shell
composer install
```

**4.Copy Environment Profile**

Copy `.env` environment configuration file, and modify database configuration information.

```shell
cp .env.example .env
```

**5.Create table**

Before creating the data table, make sure `.env` file database is configured correctly and the database already exists.

```shell
php artisan migrate
```

**6.Seed data**

Add categories data and information administrators. normal administrator account is `admin` and password is `123456` .

```shell
php artisan db:seed
```

**7.Login to dashboard**

Access `http://www.english.com/` ，Using an administrator account to log on.

## License

[MIT license](http://opensource.org/licenses/MIT) © [六阿哥](https://github.com/6ag)

