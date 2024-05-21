<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m220214_173058_alter_educator
 */
class m220214_173058_alter_educator extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema('educators');

        if (!isset($tableSchema->columns['auth_key'])) {
            $this->addColumn('educators', 'auth_key', 'VARCHAR(255) NOT NULL AFTER `email`');
        }

        if (!isset($tableSchema->columns['access_token'])) {
            $this->addColumn('educators', 'access_token', 'VARCHAR(255) NOT NULL AFTER `auth_key`');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220214_173058_alter_educator cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220214_173058_alter_educator cannot be reverted.\n";

        return false;
    }
    */
}
