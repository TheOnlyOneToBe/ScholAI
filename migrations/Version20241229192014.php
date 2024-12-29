<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241229192014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, programme_id INT NOT NULL, semestre_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date_evaluation DATETIME NOT NULL, type VARCHAR(50) NOT NULL, coefficient DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, INDEX IDX_1323A57562BB7AEE (programme_id), INDEX IDX_1323A5755577AFDB (semestre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT NOT NULL, etudiant_id INT NOT NULL, programme_id INT NOT NULL, valeur DOUBLE PRECISION NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, statut VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, created_by VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, INDEX IDX_CFBDFA14456C5646 (evaluation_id), INDEX IDX_CFBDFA14DDEAB1A3 (etudiant_id), INDEX IDX_CFBDFA1462BB7AEE (programme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A57562BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5755577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1462BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE campus DROP salle_cours');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A57562BB7AEE');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5755577AFDB');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14456C5646');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14DDEAB1A3');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1462BB7AEE');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE note');
        $this->addSql('ALTER TABLE campus ADD salle_cours VARCHAR(255) NOT NULL');
    }
}
