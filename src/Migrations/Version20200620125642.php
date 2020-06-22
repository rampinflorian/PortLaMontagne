<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200620125642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE area (id INT AUTO_INCREMENT NOT NULL, site_id INT NOT NULL, orientation VARCHAR(50) NOT NULL, dificulty_max VARCHAR(3) NOT NULL, dificulty_min VARCHAR(3) NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_D7943D68F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE climbing_group (id INT AUTO_INCREMENT NOT NULL, area_id INT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, dificulty_min VARCHAR(255) NOT NULL, dificulty_max VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, release_at DATETIME NOT NULL, is_open TINYINT(1) NOT NULL, max_climber INT NOT NULL, is_registration_opened TINYINT(1) NOT NULL, INDEX IDX_636D179CBD0F409C (area_id), INDEX IDX_636D179CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, coordinates VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE area ADD CONSTRAINT FK_D7943D68F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE climbing_group ADD CONSTRAINT FK_636D179CBD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('ALTER TABLE climbing_group ADD CONSTRAINT FK_636D179CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE climbing_group DROP FOREIGN KEY FK_636D179CBD0F409C');
        $this->addSql('ALTER TABLE area DROP FOREIGN KEY FK_D7943D68F6BD1646');
        $this->addSql('DROP TABLE area');
        $this->addSql('DROP TABLE climbing_group');
        $this->addSql('DROP TABLE site');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
