### Тестовое задание Paybox

Потратил времени примерно 6 часов
использовал php 7.4 (точнее 7.4.12)

#### Установка
- composer install
- меняем .env.example на .env
- в файле .env прописываем конфиги для базы
- Генерируем ключ php artisan key:generate
- выполнить миграцию php artisan migrate
- Пользуемся приложением

#### Дополнение
- Поиск по таблице происходит при полном соответствии строки
- Нужно также пройти регистрацию, чтобы добавлять платежи
- Ссылка(кнопка) на платеж, находится в таблице платежей, рядом с просмотром платежа
