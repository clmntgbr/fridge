<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220725081120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expiration_date_notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, days_before INT NOT NULL, INDEX IDX_86EA6648A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expiration_date_notification ADD CONSTRAINT FK_86EA6648A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE consumption_date_notification');
        $this->addSql('ALTER TABLE item CHANGE consumption_date expiration_date DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consumption_date_notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, days_before INT NOT NULL, INDEX IDX_9FF77281A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE consumption_date_notification ADD CONSTRAINT FK_9FF77281A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE expiration_date_notification');
        $this->addSql('ALTER TABLE item CHANGE expiration_date consumption_date DATE DEFAULT NULL');
    }
}
