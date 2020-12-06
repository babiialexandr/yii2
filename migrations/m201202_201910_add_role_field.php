<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m201202_201910_add_role_field
 */
class m201202_201910_add_role_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'role', Schema::TYPE_SMALLINT . '(6) NOT NULL DEFAULT 2');
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'role');
    }
}
