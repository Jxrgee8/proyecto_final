<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240225135032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE streaming (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE streaming_serie (streaming_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_65BB295429AEC72 (streaming_id), INDEX IDX_65BB295D94388BD (serie_id), PRIMARY KEY(streaming_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE streaming_serie ADD CONSTRAINT FK_65BB295429AEC72 FOREIGN KEY (streaming_id) REFERENCES streaming (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE streaming_serie ADD CONSTRAINT FK_65BB295D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE streaming_serie DROP FOREIGN KEY FK_65BB295429AEC72');
        $this->addSql('ALTER TABLE streaming_serie DROP FOREIGN KEY FK_65BB295D94388BD');
        $this->addSql('DROP TABLE streaming');
        $this->addSql('DROP TABLE streaming_serie');
    }
}
