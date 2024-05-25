<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240525140515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD COLUMN post_number INTEGER NOT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN first_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN last_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN birthday DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN postal_code VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN phone VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, created_at, updated_at, is_archived FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , is_archived INTEGER NOT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password, created_at, updated_at, is_archived) SELECT id, email, roles, password, created_at, updated_at, is_archived FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }
}
