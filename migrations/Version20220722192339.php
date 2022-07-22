<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220722192339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E6264E9E2');
        $this->addSql('DROP INDEX UNIQ_1F1B251E6264E9E2 ON item');
        $this->addSql('ALTER TABLE item DROP consumption_date_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item ADD consumption_date_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E6264E9E2 FOREIGN KEY (consumption_date_id) REFERENCES consumption_date (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F1B251E6264E9E2 ON item (consumption_date_id)');
    }
}
