# About Assessment

## Solution

For assessment code please have a look at following files and directories:

- `app/Console/*`
- `app/DTO/*`
- `app/DTO/Casters/*`
- `app/Jobs/*`
- `app/Models/*`
- `database/migrations/*`
- `app/CreditCard.php`
- `app/Reader.php`
- `app/JsonCollectionReader.php`

Tests

- `tests/Unit/*`
- `tests/Feature/*`


## Installation
- git clone https://github.com/AhmadWaleed/laravel-assessment.git
- cd in to assessment (cloned folder)
- add your db credentials in .env file
- run following commands:
```bash
$ sail up -d
$ sail artisan key:generate
$ cp .env.example .env
$ sail artisan migrate
$ sail artisan tests
```

## Extra Packages use

- **[DTO](https://github.com/spatie/data-transfer-object)**
- **[JSON Stream Parser](https://github.com/salsify/jsonstreamingparser)**
- **[PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)**

## Note
I use laravel queue jobs for processing import jobs in the background. Also i did not use excessive comment because i am not in favour of comments unless your code is not self explanatory. Test coverage is not 100 % but most of the code is covered.
