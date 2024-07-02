<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%visitor}}`.
 */
class m240702_161548_create_visitor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%visitor}}', [
            'id' => $this->primaryKey(),
            'ip' => $this->string(45),
            'user_agent' => $this->string(),
            'language' => $this->string(10),
            'os' => $this->string(45),
            'browser' => $this->string(45),
            'device' => $this->string(45),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%visitor}}');
    }
}
