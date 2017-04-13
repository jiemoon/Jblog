# Jblog

## Depends On
- php 5.6+

## Install

### 1. Clone Project
```shell
git clone https://github.com/jiemoon/Jblog.git
```

### 2. Install Composer Require
```shell
cd Jblog
composer install
```

### 3. Install Node Module

```shell
yarn // or npm install
```

### 4. Init Project

```shell
php artisan migrate --seed
yarn run dev
```

You can access the Admin Cpanel through `http://jblog.app/cpanel`
user:pwd: admin@admin.com:123456

## Deploy
> We use [Mina](http://nadarei.co/mina/) to deploy our project. 
### Install Mina
```bash
gem install mina
```

### Init Mina
```bash
mina init
```

### Modify the Mina config file

The config file will in /config/deploy.rb. You can refer to the `config/deploy.rb.sample`.

### Deploy Project

After complete the mina config, we can use `mina deploy` to deploy our project.

### Use Https

You can use [acme.sh](https://github.com/Neilpang/acme.sh) to enable https.

## Commands
### Generate Model Class
```shell
php artisan make:model Models\\Article -m
```

## Thanks
- [Laravel](https://github.com/laravel/laravel)
- [Vue](https://github.com/vuejs/vue)
- [Element](https://github.com/ElemeFE/element)
