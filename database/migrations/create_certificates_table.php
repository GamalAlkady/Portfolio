<?php

use Devamirul\PhpMicro\core\Foundation\CLI\Database\Base\BaseMigration;

class create_certificates_table extends BaseMigration {

    /**
     * Run the migrations.
     */
    public function up() {
        return static::db()->create('certificates', [
            'id' => [
                'INT',
                'NOT NULL',
                'AUTO_INCREMENT',
                'PRIMARY KEY',
            ],
            'title' => [
                'JSON',
                'NOT NULL',
            ],
            'description' => [
                'JSON',
                'DEFAULT NULL',
            ],
            'issuer' => [
                'VARCHAR(255)',
                'NOT NULL',
            ],
            'issued_date' => [
                'DATE',
                'NOT NULL',
            ],
            'expiry_date' => [
                'DATE',
                'DEFAULT NULL',
            ],
            'certificate_type' => [
                'ENUM("certificate", "award", "course", "achievement")',
                'NOT NULL',
                'DEFAULT "certificate"',
            ],
            'certificate_file' => [
                'VARCHAR(500)',
                'DEFAULT NULL',
            ],
            'verification_url' => [
                'VARCHAR(500)',
                'DEFAULT NULL',
            ],
            'skills_related' => [
                'TEXT',
                'DEFAULT NULL',
            ],
            'is_featured' => [
                'BOOLEAN',
                'DEFAULT FALSE',
            ],
            'display_order' => [
                'INT',
                'DEFAULT 0',
            ],
            'status' => [
                'ENUM("active", "inactive")',
                'NOT NULL',
                'DEFAULT "active"',
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
        return static::db()->drop('certificates');
    }
}