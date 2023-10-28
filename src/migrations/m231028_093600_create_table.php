<?php

namespace mesusah\crafttryhackme\migrations;

use Craft;
use craft\db\Migration;

/**
 * m231028_093600_create_table migration.
 */
class m231028_093600_create_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        /**
         * Tables
         */

        // Craete table tryhackme_country
        $this->createTable('{{%tryhackme_country}}', [
            'id integer auto_increment primary key',
            'name varchar(255) not null',
            'handle varchar(255) not null',
        ]);

        // Craete table tryhackme_user
        $this->createTable('{{%tryhackme_user}}', [
            'id integer auto_increment primary key',
            'name varchar(255) not null',
            'country_id integer not null',
        ]);

        // Craete table tryhackme_user_country
        $this->createTable('{{%tryhackme_user_country}}', [
            'id integer auto_increment primary key',
            'user_id integer not null',
            'country_id integer not null',
        ]);

        // Create table tryhackme_user_score
        $this->createTable('{{%tryhackme_user_score}}', [
            'id integer auto_increment primary key',
            'user_id integer not null',
            'date date not null',
            'score integer not null',
        ]);

        // Create table tryhackme_user_rank
        $this->createTable('{{%tryhackme_user_rank}}', [
            'id integer auto_increment primary key',
            'user_id integer not null',
            'date date not null',
            'score integer not null',
        ]);



        /**
         * Foreign keys
         */

        // Add foreign keys for table tryhackme_user_country
        $this->addForeignKey(
            'fk-tryhackme_user_country-user_id',
            '{{%tryhackme_user_country}}',
            'user_id',
            '{{%tryhackme_user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tryhackme_user_country-country_id',
            '{{%tryhackme_user_country}}',
            'country_id',
            '{{%tryhackme_country}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Add foreign key for table tryhackme_user
        $this->addForeignKey(
            'fk-tryhackme_user-country',
            '{{%tryhackme_user}}',
            'country_id',
            '{{%tryhackme_country}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Add foreign key for table tryhackme_user_score
        $this->addForeignKey(
            'fk-tryhackme_user_score-user_id',
            '{{%tryhackme_user_score}}',
            'user_id',
            '{{%tryhackme_user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Add foreign key for table tryhackme_user_rank
        $this->addForeignKey(
            'fk-tryhackme_user_rank-user_id',
            '{{%tryhackme_user_rank}}',
            'user_id',
            '{{%tryhackme_user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        $this->dropTable('{{%tryhackme_user_country}}');
        $this->dropTable('{{%tryhackme_user_rank}}');
        $this->dropTable('{{%tryhackme_user_score}}');
        $this->dropTable('{{%tryhackme_user}}');
        $this->dropTable('{{%tryhackme_country}}');
        return true;
    }
}
