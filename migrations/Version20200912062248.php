<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200912062248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE market_product (id INT AUTO_INCREMENT NOT NULL, vendor_id INT NOT NULL, buyer_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, is_sold TINYINT(1) NOT NULL, is_suspended TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, solded_at DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_DADCEC2DF603EE73 (vendor_id), INDEX IDX_DADCEC2D6C755722 (buyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE market_product ADD CONSTRAINT FK_DADCEC2DF603EE73 FOREIGN KEY (vendor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE market_product ADD CONSTRAINT FK_DADCEC2D6C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE market_product');
    }
}
