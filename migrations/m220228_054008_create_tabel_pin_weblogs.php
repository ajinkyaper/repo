<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m220228_054008_create_tabel_pin_weblogs
 */
class m220228_054008_create_tabel_pin_weblogs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $tableSchema = Yii::$app->db->schema->getTableSchema('pin_weblogs');
        if ($tableSchema != "") {
            $this->dropTable('{{%pin_weblogs}}');
        }
        $this->createTable('{{%pin_weblogs}}', [
            'id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`)',
            'pin' => $this->integer()->notNull(),
            'ip' => $this->string(20)->notNull(),
            'created_at' => $this->timestamp()->notNull()->append('DEFAULT CURRENT_TIMESTAMP')

        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('pin_weblogs');
    }
}
