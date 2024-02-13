<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213180355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plataforma (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plataforma_serie (plataforma_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_5D498884EB90E430 (plataforma_id), INDEX IDX_5D498884D94388BD (serie_id), PRIMARY KEY(plataforma_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plataforma_serie ADD CONSTRAINT FK_5D498884EB90E430 FOREIGN KEY (plataforma_id) REFERENCES plataforma (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plataforma_serie ADD CONSTRAINT FK_5D498884D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serie DROP plataforma');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plataforma_serie DROP FOREIGN KEY FK_5D498884EB90E430');
        $this->addSql('ALTER TABLE plataforma_serie DROP FOREIGN KEY FK_5D498884D94388BD');
        $this->addSql('DROP TABLE plataforma');
        $this->addSql('DROP TABLE plataforma_serie');
        $this->addSql('ALTER TABLE serie ADD plataforma LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\'');
    }
}
