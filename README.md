# testphp
Дамп новой БД (с таблицей пользователей) - fulldump.sql

Основной алгоритм:


- Контроллеры и экшены указываются формате index.php?r=site/index, где site - контроллер, а index - экшн

- Метод App->run() получает название контроллера и экшна из адресной строки и запускает метод Controller ->launchAction()

- Controller ->launchAction() проверяет есть ли такие контроллер/экшн и запускает найденный экшн

- Экшн получает из БД данные с помощью моделей

- Метод экшена renderView() передает данные во view и отрисовывает её

- В папке layouts находится шаблон, в котором подключаются js- и css-файлы

В коде есть коментарии по конкретным методам

