<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240202162143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capitulos (id INT AUTO_INCREMENT NOT NULL, temporada_id INT NOT NULL, numero_cap INT NOT NULL, INDEX IDX_6622F4586E1CF8A8 (temporada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lista (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie (id INT AUTO_INCREMENT NOT NULL, lista_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, fecha_lanzamiento DATE DEFAULT NULL, plataforma LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', genero LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_AA3A93346736D68F (lista_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE temporada (id INT AUTO_INCREMENT NOT NULL, serie_id INT NOT NULL, numero_temp INT NOT NULL, INDEX IDX_9A6BDEBDD94388BD (serie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE capitulos ADD CONSTRAINT FK_6622F4586E1CF8A8 FOREIGN KEY (temporada_id) REFERENCES temporada (id)');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A93346736D68F FOREIGN KEY (lista_id) REFERENCES lista (id)');
        $this->addSql('ALTER TABLE temporada ADD CONSTRAINT FK_9A6BDEBDD94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capitulos DROP FOREIGN KEY FK_6622F4586E1CF8A8');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A93346736D68F');
        $this->addSql('ALTER TABLE temporada DROP FOREIGN KEY FK_9A6BDEBDD94388BD');
        $this->addSql('DROP TABLE capitulos');
        $this->addSql('DROP TABLE lista');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE temporada');
    }
}
