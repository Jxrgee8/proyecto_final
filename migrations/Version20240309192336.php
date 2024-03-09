<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240309192336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contador (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, serie_id INT DEFAULT NULL, temporada_id INT DEFAULT NULL, capitulo INT DEFAULT NULL, INDEX IDX_E83EF8FADB38439E (usuario_id), INDEX IDX_E83EF8FAD94388BD (serie_id), INDEX IDX_E83EF8FA6E1CF8A8 (temporada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contador ADD CONSTRAINT FK_E83EF8FADB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE contador ADD CONSTRAINT FK_E83EF8FAD94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE contador ADD CONSTRAINT FK_E83EF8FA6E1CF8A8 FOREIGN KEY (temporada_id) REFERENCES temporada (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contador DROP FOREIGN KEY FK_E83EF8FADB38439E');
        $this->addSql('ALTER TABLE contador DROP FOREIGN KEY FK_E83EF8FAD94388BD');
        $this->addSql('ALTER TABLE contador DROP FOREIGN KEY FK_E83EF8FA6E1CF8A8');
        $this->addSql('DROP TABLE contador');
    }
}
