<?php

namespace mesusah\crafttryhackme\migrations;

use Craft;
use craft\db\Migration;

/**
 * m231029_112849_add_avatar_to_user migration.
 */
class m231029_112849_add_avatar_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $this->addColumn('{{%tryhackme_user}}', 'avatar', $this->string(255)->null());

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        $this->dropColumn('{{%tryhackme_user}}', 'avatar');
        return true;
    }
}
