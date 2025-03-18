# Требования к стеку технологий
PHP 8, Laravel ^11
Postgres / Mysql
vue3(приоритет) / jquery
scss / css, bootrstrap 5
https://getbootstrap.com/docs/5.1/examples/
при создании базы использовать миграции Laravel
для js and css/scss использовать Laravel Mix/Vite


# Структура БД

Продумать структуру следующих таблиц:
* таблица пользователей
* таблица баланса пользователя
* таблица операций

в текущей задаче таблица балансов не нужна, тк в ней существует только запись user_id - balance и связь идет один к одному
одно дополнительное поле таблице users не повредит, а вывод информации о балансе пользователя сократит на один join

# Структура сайта
* Логин
* Главная страница
отображает текущий баланс пользователя и пять последних операций
обновление всех данных через T секунд (ajax)
* История операций
отображает таблицу операций с сортировкой по полю “дата” и поиском по полю “описание”

# Бэкенд
Через консольную команду (artisan) сделать:
* добавление пользователей
* проведение операций по балансу пользователя, по логину (начисление/списание) с указанием описания операции, не давать уводить баланс в минус

Отдельным плюсом будет реализация проведения операций по балансу с использованием Laravel Queues
