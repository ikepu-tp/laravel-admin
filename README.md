# Laravel Admin

[日本語版](https://qiita.com/ikepu-tp/items/f86a2f8f2557d0f77184)

This is a library to add administrator functionality to `Laravel Project`.

## Features

- Set administrators from users
- Show the list of users

## How to use

### 1. Install from `composer`

```bash
composer require ikepu-tp/laravel-admin
```

### 2. Publish configure file

```bash
php artisan vendor:publish --tag=laravelAdmin-config
```

### 3. Migrate

```bash
php artisan migrate
```

### 4. Add `UserTrait` to `User.php`

```php
class User extends Model {
    use \ikepu_tp\LaravelAdmin\app\Models\UserTrait;
```

### 5. Set administrator at the first time

```mysql
insert into user_grants (user_id,grant) values (`your user_id`,0)
```

At the first time, you have to set administrator by SQL but you can set on [http://localhost/admin/users](http://localhost/admin/users) after that.

## Contributing

Thank you for your contributions. If you find bugs, let me know them with issues.

## License

Copyright (c) 2023 ikepu-tp.

This is open-sourced software licensed under the [MIT license](LICENSE).
