<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240309190042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capitulo DROP FOREIGN KEY FK_2BA5E28F6E1CF8A8');
        $this->addSql('DROP TABLE capitulo');
        $this->addSql('ALTER TABLE temporada ADD capitulos INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capitulo (id INT AUTO_INCREMENT NOT NULL, temporada_id INT NOT NULL, numero_capitulos INT NOT NULL, fecha_creacion DATE NOT NULL, INDEX IDX_2BA5E28F6E1CF8A8 (temporada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE capitulo ADD CONSTRAINT FK_2BA5E28F6E1CF8A8 FOREIGN KEY (temporada_id) REFERENCES temporada (id)');
        $this->addSql('ALTER TABLE temporada DROP capitulos');
    }
}
