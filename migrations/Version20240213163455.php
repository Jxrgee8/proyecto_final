<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213163455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genero (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genero_serie (genero_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_DD0DFD50BCE7B795 (genero_id), INDEX IDX_DD0DFD50D94388BD (serie_id), PRIMARY KEY(genero_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE genero_serie ADD CONSTRAINT FK_DD0DFD50BCE7B795 FOREIGN KEY (genero_id) REFERENCES genero (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genero_serie ADD CONSTRAINT FK_DD0DFD50D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serie DROP genero');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genero_serie DROP FOREIGN KEY FK_DD0DFD50BCE7B795');
        $this->addSql('ALTER TABLE genero_serie DROP FOREIGN KEY FK_DD0DFD50D94388BD');
        $this->addSql('DROP TABLE genero');
        $this->addSql('DROP TABLE genero_serie');
        $this->addSql('ALTER TABLE serie ADD genero LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');
    }
}
