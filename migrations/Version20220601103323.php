<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601103323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fridge (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, uuid VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_F2E94D89D17F50A6 (uuid), INDEX IDX_F2E94D89A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, product_status_id INT DEFAULT NULL, ean VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, image_ingredients_url VARCHAR(255) NOT NULL, image_nutrition_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_D34A04AD67B1C660 (ean), INDEX IDX_D34A04AD557B630 (product_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_status (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(50) NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_status_history (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, product_status_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_7C0379E24584665A (product_id), INDEX IDX_7C0379E2557B630 (product_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(200) NOT NULL, username VARCHAR(200) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_enable TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fridge ADD CONSTRAINT FK_F2E94D89A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD557B630 FOREIGN KEY (product_status_id) REFERENCES product_status (id)');
        $this->addSql('ALTER TABLE product_status_history ADD CONSTRAINT FK_7C0379E24584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_status_history ADD CONSTRAINT FK_7C0379E2557B630 FOREIGN KEY (product_status_id) REFERENCES product_status (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_status_history DROP FOREIGN KEY FK_7C0379E24584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD557B630');
        $this->addSql('ALTER TABLE product_status_history DROP FOREIGN KEY FK_7C0379E2557B630');
        $this->addSql('ALTER TABLE fridge DROP FOREIGN KEY FK_F2E94D89A76ED395');
        $this->addSql('DROP TABLE fridge');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_status');
        $this->addSql('DROP TABLE product_status_history');
        $this->addSql('DROP TABLE user');
    }
}
