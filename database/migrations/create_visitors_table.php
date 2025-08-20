<?php

use Devamirul\PhpMicro\core\Foundation\CLI\Database\Base\BaseMigration;

class create_visitors_table extends BaseMigration {

    /**
     * Run the migrations.
     */
    public function up() {
        return static::db()->create('visitors', [
            'id' => [
                'INT',
                'NOT NULL',
                'AUTO_INCREMENT',
                'PRIMARY KEY',
            ],
            'ip_address' => [
                'VARCHAR(45)',
                'NOT NULL',
            ],
            'user_agent' => [
                'TEXT',
                'DEFAULT NULL',
            ],
            'page_url' => [
                'VARCHAR(500)',
                'DEFAULT NULL',
            ],
            'referer' => [
                'VARCHAR(500)',
                'DEFAULT NULL',
            ],
            'country' => [
                'VARCHAR(100)',
                'DEFAULT NULL',
            ],
            'city' => [
                'VARCHAR(100)',
                'DEFAULT NULL',
            ],
            'session_id' => [
                'VARCHAR(100)',
                'DEFAULT NULL',
            ],
            'is_unique' => [
                'BOOLEAN',
                'DEFAULT TRUE',
            ],
            'visit_date' => [
                'DATE',
                'NOT NULL',
            ],
            'visit_time' => [
                'TIME',
                'NOT NULL',
            ],
            'created_at' => [
                'TIMESTAMP',
                'NOT NULL',
                'DEFAULT CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'TIMESTAMP',
                'NOT NULL',
                'DEFAULT NOW()',
                'ON UPDATE NOW()',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        return static::db()->drop('visitors');
    }
}