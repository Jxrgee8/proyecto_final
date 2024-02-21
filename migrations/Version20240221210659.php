<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240221210659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE serie_genero (serie_id INT NOT NULL, genero_id INT NOT NULL, INDEX IDX_57AAD353D94388BD (serie_id), INDEX IDX_57AAD353BCE7B795 (genero_id), PRIMARY KEY(serie_id, genero_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie_plataforma (serie_id INT NOT NULL, plataforma_id INT NOT NULL, INDEX IDX_F108C01AD94388BD (serie_id), INDEX IDX_F108C01AEB90E430 (plataforma_id), PRIMARY KEY(serie_id, plataforma_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE serie_genero ADD CONSTRAINT FK_57AAD353D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serie_genero ADD CONSTRAINT FK_57AAD353BCE7B795 FOREIGN KEY (genero_id) REFERENCES genero (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serie_plataforma ADD CONSTRAINT FK_F108C01AD94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serie_plataforma ADD CONSTRAINT FK_F108C01AEB90E430 FOREIGN KEY (plataforma_id) REFERENCES plataforma (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genero_serie DROP FOREIGN KEY FK_DD0DFD50D94388BD');
        $this->addSql('ALTER TABLE genero_serie DROP FOREIGN KEY FK_DD0DFD50BCE7B795');
        $this->addSql('ALTER TABLE plataforma_serie DROP FOREIGN KEY FK_5D498884EB90E430');
        $this->addSql('ALTER TABLE plataforma_serie DROP FOREIGN KEY FK_5D498884D94388BD');
        $this->addSql('DROP TABLE genero_serie');
        $this->addSql('DROP TABLE plataforma_serie');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genero_serie (genero_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_DD0DFD50BCE7B795 (genero_id), INDEX IDX_DD0DFD50D94388BD (serie_id), PRIMARY KEY(genero_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE plataforma_serie (plataforma_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_5D498884EB90E430 (plataforma_id), INDEX IDX_5D498884D94388BD (serie_id), PRIMARY KEY(plataforma_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE genero_serie ADD CONSTRAINT FK_DD0DFD50D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genero_serie ADD CONSTRAINT FK_DD0DFD50BCE7B795 FOREIGN KEY (genero_id) REFERENCES genero (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plataforma_serie ADD CONSTRAINT FK_5D498884EB90E430 FOREIGN KEY (plataforma_id) REFERENCES plataforma (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plataforma_serie ADD CONSTRAINT FK_5D498884D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serie_genero DROP FOREIGN KEY FK_57AAD353D94388BD');
        $this->addSql('ALTER TABLE serie_genero DROP FOREIGN KEY FK_57AAD353BCE7B795');
        $this->addSql('ALTER TABLE serie_plataforma DROP FOREIGN KEY FK_F108C01AD94388BD');
        $this->addSql('ALTER TABLE serie_plataforma DROP FOREIGN KEY FK_F108C01AEB90E430');
        $this->addSql('DROP TABLE serie_genero');
        $this->addSql('DROP TABLE serie_plataforma');
    }
}
