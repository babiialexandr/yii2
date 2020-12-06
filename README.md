docker-compose exec app yii migrate --migrationPath=@yii/rbac/migrations


docker-compose exec app yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations

docker-compose exec app yii migrate