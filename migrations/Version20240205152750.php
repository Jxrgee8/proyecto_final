<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240205152750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lista ADD usuario_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE lista ADD CONSTRAINT FK_FB9FEEED629AF449 FOREIGN KEY (usuario_id_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_FB9FEEED629AF449 ON lista (usuario_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lista DROP FOREIGN KEY FK_FB9FEEED629AF449');
        $this->addSql('DROP INDEX IDX_FB9FEEED629AF449 ON lista');
        $this->addSql('ALTER TABLE lista DROP usuario_id_id');
    }
}
