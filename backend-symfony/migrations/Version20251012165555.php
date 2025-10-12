<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251012165555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name CLOB NOT NULL)');
        $this->addSql('CREATE TABLE listing (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, listing_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, price INTEGER NOT NULL, currency VARCHAR(5) NOT NULL, location VARCHAR(55) NOT NULL, status VARCHAR(55) NOT NULL, CONSTRAINT FK_CB0048D412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CB0048D4D4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CB0048D412469DE2 ON listing (category_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB0048D4D4619D1A ON listing (listing_id)');
        $this->addSql('CREATE TABLE listing_image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, listing_id INTEGER NOT NULL, location CLOB NOT NULL, CONSTRAINT FK_33D3DCD3D4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_33D3DCD3D4619D1A ON listing_image (listing_id)');
        $this->addSql('CREATE TABLE listing_payment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, amount INTEGER NOT NULL, currency VARCHAR(5) NOT NULL, status VARCHAR(55) NOT NULL, provider VARCHAR(55) NOT NULL)');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, receiver_id INTEGER NOT NULL, sender_id INTEGER NOT NULL, content VARCHAR(255) NOT NULL, is_seen BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_B6BD307FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B6BD307FCD53EDB6 ON message (receiver_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FF624B39D ON message (sender_id)');
        $this->addSql('CREATE TABLE review (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, listing_id INTEGER DEFAULT NULL, rating INTEGER NOT NULL, content VARCHAR(255) NOT NULL, CONSTRAINT FK_794381C6F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_794381C6D4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_794381C6F675F31B ON review (author_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_794381C6D4619D1A ON review (listing_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(155) NOT NULL, display_name VARCHAR(55) NOT NULL, phone VARCHAR(15) NOT NULL, location VARCHAR(55) NOT NULL, language VARCHAR(5) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE listing');
        $this->addSql('DROP TABLE listing_image');
        $this->addSql('DROP TABLE listing_payment');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE user');
    }
}
