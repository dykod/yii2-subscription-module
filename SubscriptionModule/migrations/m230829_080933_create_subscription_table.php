<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscription}}`.
 */
class m230829_080933_create_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('subscription', [
            'id' => $this->primaryKey(),
            'event' => "ENUM('reg', 'login', 'verify', 'message', 'logout')",
            'recipient' => $this->text(),
            'is_block' => $this->tinyInteger(1)->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('subscription');
    }
}
