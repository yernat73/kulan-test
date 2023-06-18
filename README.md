<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Installation & Setup

The easiest way to build this application is to use [Laravel Sail](https://github.com/laravel/sail). It's installed via the Composer package manager. Let's assume that local php version will not allow us to run installation command. Run this command, so we can ignore our existing local environment specifications.

```shell
composer install --ignore-platform-reqs
```

Create `.env` file.

```shell
cp .env.example .env
```

At this point you can edit database name by your preferences. Sail will create automatically database with name that was specified in your `.env` file on first run. If you decide to change database name after the containers were created, you can create database manually inside the `mysql` container or recreate the containers which will run sail's initial scripts.

Create our Docker Containers.

```shell
./vendor/bin/sail up
```

Generate `APP_KEY`.

```shell
./vendor/bin/sail artisan key:generate
```

Create the symbolic link.

```shell
./vendor/bin/sail artisan storage:link
```

Run migrations.

```shell
./vendor/bin/sail artisan migrate:fresh --seed
```

# Configuring A Shell Alias

By default, Sail commands are invoked using the `vendor/bin/sail` script that is included with all new Laravel applications:

```shell
./vendor/bin/sail up
```

However, instead of repeatedly typing `vendor/bin/sail` to execute Sail commands, you may wish to configure a shell alias that allows you to execute Sail's commands more easily:

```shell
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

To make sure this is always available, you may add this to your shell configuration file in your home directory, such as `~/.zshrc` or `~/.bashrc`, and then restart your shell.

Once the shell alias has been configured, you may execute Sail commands by simply typing `sail`. The remainder of this documentation's examples will assume that you have configured this alias:

```shell
sail up
```

# Credentials

At first entrance application will be redirected to login page. `UserSeeder` have already created `super-admin` user, with all the permissions.


| Email | Password |
| ------ | ------ | 
| admin@kulan.kz | 123456789 |

If you register using `/admin/register` page, this will create basic user with minimal permissions, that includes: creating & viewing own `Delivery` records, viewing all the `Cities` available in the application.
