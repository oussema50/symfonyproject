<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231208184236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restau ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restau ADD CONSTRAINT FK_D001E5FF19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_D001E5FF19EB6921 ON restau (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restau DROP FOREIGN KEY FK_D001E5FF19EB6921');
        $this->addSql('DROP INDEX IDX_D001E5FF19EB6921 ON restau');
        $this->addSql('ALTER TABLE restau DROP client_id');
    }
}
