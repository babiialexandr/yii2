<?php

use yii\db\Migration;

/**
 * Class m201206_130517_import_admin_user
 */
class m201206_130517_import_admin_user extends Migration
{
    public function up()
    {
        \Yii::$app->db->createCommand(
            'INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `created_at`, `updated_at`, `flags`, `last_login_at`, `role`) VALUES
(9, \'admin\', \'admin@admin.com\', \'$2y$10$Q/oqqWwNavkYOl8XuJWyIessMcnyJYTyFUJSBoGIEI1NtTRmkFP8m\', \'Roj9xafEBHDhjtFuf0QxeQHwZLs5uWZU\', 1607179672, NULL, NULL, NULL, 1606936911, 1607184509, 0, 1607259338, 2);'
        )->execute();
    }

    public function down()
    {
        \Yii::$app->db->createCommand('DELETE FROM `user` WHERE id = 9;')->execute();
    }
}
