1. git clone https://github.com/babiialexandr/yii2.git
2. cd yii2
3. docker-compose up -d
4. docker-compose exec app composer install
5. docker-compose exec app yii migrate --migrationPath=@yii/rbac/migrations
6. docker-compose exec app yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
7. docker-compose exec app yii migrate
8. docker-compose exec app yii rbac/init
9. sudo nano /etc/hosts -> 127.0.0.1 babii.test
10. sudo chmod 777 -R web/assets/
11. sudo chmod 777 -R runtime/
12. http://babii.test логинимся (admin:123456)
13. http://babii.test/user/admin - тут админка

14. Остановить докер: docker-compose stop
15. Остановить докер и удалить все контейнеры: docker-compose down