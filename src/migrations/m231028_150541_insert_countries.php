<?php

namespace mesusah\crafttryhackme\migrations;

use Craft;
use craft\db\Migration;

/**
 * m231028_150541_insert_countries migration.
 */
class m231028_150541_insert_countries extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $fields = [
            'handle',
            'name',
        ];
        $data = [
            ['no', 'Norway'],
            ['se', 'Sweeden'],
            ['dk', 'Denmark'],
            ['fi', 'Finland'],
            ['is', 'Iceland'],
        ];        
        $this->batchInsert('{{%tryhackme_country}}', $fields, $data);
        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        $this->delete('{{%tryhackme_country}}', [
            'handle' => ['no', 'se', 'dk', 'fi', 'is']
        ]);
        return true;
    }
}
