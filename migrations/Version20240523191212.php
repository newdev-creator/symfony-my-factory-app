<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240523191212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, factory, address, postal_code, city, email, phone, contact_primary, created_at, updated_at FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, factory VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, contact_primary VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO client (id, factory, address, postal_code, city, email, phone, contact_primary, created_at, updated_at) SELECT id, factory, address, postal_code, city, email, phone, contact_primary, created_at, updated_at FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE TEMPORARY TABLE __temp__order AS SELECT id, client_id, product_id, start_date, created_at, updated_at FROM "order"');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER NOT NULL, product_id INTEGER NOT NULL, start_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_F529939819EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F52993984584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "order" (id, client_id, product_id, start_date, created_at, updated_at) SELECT id, client_id, product_id, start_date, created_at, updated_at FROM __temp__order');
        $this->addSql('DROP TABLE __temp__order');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F52993984584665A ON "order" (product_id)');
        $this->addSql('CREATE INDEX IDX_F529939819EB6921 ON "order" (client_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__plan_and_schema AS SELECT id, title, description, img_url, pdf_url, created_at, updated_at FROM plan_and_schema');
        $this->addSql('DROP TABLE plan_and_schema');
        $this->addSql('CREATE TABLE plan_and_schema (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, img_url VARCHAR(255) NOT NULL, pdf_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO plan_and_schema (id, title, description, img_url, pdf_url, created_at, updated_at) SELECT id, title, description, img_url, pdf_url, created_at, updated_at FROM __temp__plan_and_schema');
        $this->addSql('DROP TABLE __temp__plan_and_schema');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, plan_and_schema_id, name, decription, unit_price, supplier, start_date, end_date, created_at, updated_at FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, plan_and_schema_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, unit_price DOUBLE PRECISION NOT NULL, supplier VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , end_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_D34A04ADB7732598 FOREIGN KEY (plan_and_schema_id) REFERENCES plan_and_schema (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, plan_and_schema_id, name, description, unit_price, supplier, start_date, end_date, created_at, updated_at) SELECT id, plan_and_schema_id, name, decription, unit_price, supplier, start_date, end_date, created_at, updated_at FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADB7732598 ON product (plan_and_schema_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, created_at, updated_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO user (id, email, roles, password, created_at, updated_at) SELECT id, email, roles, password, created_at, updated_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, factory, address, postal_code, city, email, phone, contact_primary, created_at, updated_at FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, factory VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, contact_primary VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO client (id, factory, address, postal_code, city, email, phone, contact_primary, created_at, updated_at) SELECT id, factory, address, postal_code, city, email, phone, contact_primary, created_at, updated_at FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE TEMPORARY TABLE __temp__order AS SELECT id, client_id, product_id, start_date, created_at, updated_at FROM "order"');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER NOT NULL, product_id INTEGER NOT NULL, start_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, CONSTRAINT FK_F529939819EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F52993984584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "order" (id, client_id, product_id, start_date, created_at, updated_at) SELECT id, client_id, product_id, start_date, created_at, updated_at FROM __temp__order');
        $this->addSql('DROP TABLE __temp__order');
        $this->addSql('CREATE INDEX IDX_F529939819EB6921 ON "order" (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F52993984584665A ON "order" (product_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__plan_and_schema AS SELECT id, title, description, img_url, pdf_url, created_at, updated_at FROM plan_and_schema');
        $this->addSql('DROP TABLE plan_and_schema');
        $this->addSql('CREATE TABLE plan_and_schema (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, img_url VARCHAR(255) NOT NULL, pdf_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO plan_and_schema (id, title, description, img_url, pdf_url, created_at, updated_at) SELECT id, title, description, img_url, pdf_url, created_at, updated_at FROM __temp__plan_and_schema');
        $this->addSql('DROP TABLE __temp__plan_and_schema');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, plan_and_schema_id, name, description, unit_price, supplier, start_date, end_date, created_at, updated_at FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, plan_and_schema_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, decription CLOB NOT NULL, unit_price DOUBLE PRECISION NOT NULL, supplier VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , end_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, CONSTRAINT FK_D34A04ADB7732598 FOREIGN KEY (plan_and_schema_id) REFERENCES plan_and_schema (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, plan_and_schema_id, name, decription, unit_price, supplier, start_date, end_date, created_at, updated_at) SELECT id, plan_and_schema_id, name, description, unit_price, supplier, start_date, end_date, created_at, updated_at FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADB7732598 ON product (plan_and_schema_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, created_at, updated_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password, created_at, updated_at) SELECT id, email, roles, password, created_at, updated_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }
}
