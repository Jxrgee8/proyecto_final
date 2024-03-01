<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301170026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capitulo (id INT AUTO_INCREMENT NOT NULL, temporada_id INT NOT NULL, numero_cap INT NOT NULL, fecha_creacion DATE NOT NULL, INDEX IDX_2BA5E28F6E1CF8A8 (temporada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE director (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(90) NOT NULL, fecha_creacion DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE director_serie (director_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_503D0CE6899FB366 (director_id), INDEX IDX_503D0CE6D94388BD (serie_id), PRIMARY KEY(director_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genero (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, fecha_creacion DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genero_serie (genero_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_DD0DFD50BCE7B795 (genero_id), INDEX IDX_DD0DFD50D94388BD (serie_id), PRIMARY KEY(genero_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lista (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, tipo_lista VARCHAR(60) NOT NULL, fecha_creacion DATE NOT NULL, INDEX IDX_FB9FEEEDDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, fecha_lanzamiento INT NOT NULL, sinopsis VARCHAR(500) DEFAULT NULL, poster_src VARCHAR(255) DEFAULT NULL, fecha_creacion DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie_lista (id INT AUTO_INCREMENT NOT NULL, serie_id INT DEFAULT NULL, lista_id INT DEFAULT NULL, fecha_agregado DATE NOT NULL, INDEX IDX_3393DA79D94388BD (serie_id), INDEX IDX_3393DA796736D68F (lista_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE streaming (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, icono_src VARCHAR(60) DEFAULT NULL, fecha_creacion DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE streaming_serie (streaming_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_65BB295429AEC72 (streaming_id), INDEX IDX_65BB295D94388BD (serie_id), PRIMARY KEY(streaming_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE temporada (id INT AUTO_INCREMENT NOT NULL, serie_id INT NOT NULL, numero_temp INT NOT NULL, fecha_creacion DATE NOT NULL, INDEX IDX_9A6BDEBDD94388BD (serie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(80) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(20) NOT NULL, fecha_creacion DATE NOT NULL, UNIQUE INDEX UNIQ_2265B05DE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE capitulo ADD CONSTRAINT FK_2BA5E28F6E1CF8A8 FOREIGN KEY (temporada_id) REFERENCES temporada (id)');
        $this->addSql('ALTER TABLE director_serie ADD CONSTRAINT FK_503D0CE6899FB366 FOREIGN KEY (director_id) REFERENCES director (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE director_serie ADD CONSTRAINT FK_503D0CE6D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genero_serie ADD CONSTRAINT FK_DD0DFD50BCE7B795 FOREIGN KEY (genero_id) REFERENCES genero (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genero_serie ADD CONSTRAINT FK_DD0DFD50D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lista ADD CONSTRAINT FK_FB9FEEEDDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE serie_lista ADD CONSTRAINT FK_3393DA79D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE serie_lista ADD CONSTRAINT FK_3393DA796736D68F FOREIGN KEY (lista_id) REFERENCES lista (id)');
        $this->addSql('ALTER TABLE streaming_serie ADD CONSTRAINT FK_65BB295429AEC72 FOREIGN KEY (streaming_id) REFERENCES streaming (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE streaming_serie ADD CONSTRAINT FK_65BB295D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE temporada ADD CONSTRAINT FK_9A6BDEBDD94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capitulo DROP FOREIGN KEY FK_2BA5E28F6E1CF8A8');
        $this->addSql('ALTER TABLE director_serie DROP FOREIGN KEY FK_503D0CE6899FB366');
        $this->addSql('ALTER TABLE director_serie DROP FOREIGN KEY FK_503D0CE6D94388BD');
        $this->addSql('ALTER TABLE genero_serie DROP FOREIGN KEY FK_DD0DFD50BCE7B795');
        $this->addSql('ALTER TABLE genero_serie DROP FOREIGN KEY FK_DD0DFD50D94388BD');
        $this->addSql('ALTER TABLE lista DROP FOREIGN KEY FK_FB9FEEEDDB38439E');
        $this->addSql('ALTER TABLE serie_lista DROP FOREIGN KEY FK_3393DA79D94388BD');
        $this->addSql('ALTER TABLE serie_lista DROP FOREIGN KEY FK_3393DA796736D68F');
        $this->addSql('ALTER TABLE streaming_serie DROP FOREIGN KEY FK_65BB295429AEC72');
        $this->addSql('ALTER TABLE streaming_serie DROP FOREIGN KEY FK_65BB295D94388BD');
        $this->addSql('ALTER TABLE temporada DROP FOREIGN KEY FK_9A6BDEBDD94388BD');
        $this->addSql('DROP TABLE capitulo');
        $this->addSql('DROP TABLE director');
        $this->addSql('DROP TABLE director_serie');
        $this->addSql('DROP TABLE genero');
        $this->addSql('DROP TABLE genero_serie');
        $this->addSql('DROP TABLE lista');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE serie_lista');
        $this->addSql('DROP TABLE streaming');
        $this->addSql('DROP TABLE streaming_serie');
        $this->addSql('DROP TABLE temporada');
        $this->addSql('DROP TABLE usuario');
    }
}
