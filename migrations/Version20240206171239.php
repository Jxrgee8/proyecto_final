<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206171239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capitulo (id INT AUTO_INCREMENT NOT NULL, temporada_id INT NOT NULL, numero_cap INT NOT NULL, INDEX IDX_2BA5E28F6E1CF8A8 (temporada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE capitulo ADD CONSTRAINT FK_2BA5E28F6E1CF8A8 FOREIGN KEY (temporada_id) REFERENCES temporada (id)');
        $this->addSql('ALTER TABLE capitulos DROP FOREIGN KEY FK_6622F4586E1CF8A8');
        $this->addSql('DROP TABLE capitulos');
        $this->addSql('ALTER TABLE usuario CHANGE email email VARCHAR(80) NOT NULL, CHANGE username username VARCHAR(20) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DF85E0677 ON usuario (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capitulos (id INT AUTO_INCREMENT NOT NULL, temporada_id INT NOT NULL, numero_cap INT NOT NULL, INDEX IDX_6622F4586E1CF8A8 (temporada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE capitulos ADD CONSTRAINT FK_6622F4586E1CF8A8 FOREIGN KEY (temporada_id) REFERENCES temporada (id)');
        $this->addSql('ALTER TABLE capitulo DROP FOREIGN KEY FK_2BA5E28F6E1CF8A8');
        $this->addSql('DROP TABLE capitulo');
        $this->addSql('DROP INDEX UNIQ_2265B05DF85E0677 ON usuario');
        $this->addSql('ALTER TABLE usuario CHANGE email email VARCHAR(180) NOT NULL, CHANGE username username VARCHAR(25) NOT NULL');
    }
}
