<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241227085405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annee (id INT AUTO_INCREMENT NOT NULL, year_start DATE NOT NULL, year_end DATE NOT NULL, year_statut TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campus (id INT AUTO_INCREMENT NOT NULL, campus_id INT DEFAULT NULL, nom_campus VARCHAR(100) NOT NULL, adresse VARCHAR(200) NOT NULL, salle_cours VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_9D0968111DC6F746 (nom_campus), INDEX IDX_9D096811AF5D55E1 (campus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cycle (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, nom_departement VARCHAR(100) NOT NULL, description VARCHAR(200) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emploi_temps (id INT AUTO_INCREMENT NOT NULL, salle_id INT NOT NULL, programme_id INT NOT NULL, date DATE NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, INDEX IDX_50D1B05EDC304035 (salle_id), INDEX IDX_50D1B05E62BB7AEE (programme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, noms VARCHAR(100) NOT NULL, prenoms VARCHAR(100) NOT NULL, age INT NOT NULL, telephone VARCHAR(20) DEFAULT NULL, adresse_student VARCHAR(150) DEFAULT NULL, photo VARCHAR(25) DEFAULT NULL, sexe_etudiant VARCHAR(1) NOT NULL, matricule_student VARCHAR(50) NOT NULL, student_father VARCHAR(150) NOT NULL, student_mother VARCHAR(150) NOT NULL, father_number VARCHAR(20) DEFAULT NULL, mother_number VARCHAR(20) DEFAULT NULL, student_email VARCHAR(70) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filiere (id INT AUTO_INCREMENT NOT NULL, libellefiliere VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filiere_cycle (id INT AUTO_INCREMENT NOT NULL, filiere_id INT DEFAULT NULL, cycle_id INT DEFAULT NULL, inscription INT NOT NULL, pension INT NOT NULL, description VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_C9D69335180AA129 (filiere_id), INDEX IDX_C9D693355EC1162 (cycle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, filierecycle_id INT NOT NULL, annee_id INT NOT NULL, etudiant_id INT NOT NULL, date_inscription DATETIME NOT NULL, statut_inscription TINYINT(1) NOT NULL, INDEX IDX_5E90F6D6112BB29C (filierecycle_id), INDEX IDX_5E90F6D6543EC5F0 (annee_id), INDEX IDX_5E90F6D6DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, uniteenseignement VARCHAR(200) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payement_method (id INT AUTO_INCREMENT NOT NULL, payement_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payement_reason (id INT AUTO_INCREMENT NOT NULL, libelle_raison VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, departement_id INT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(200) NOT NULL, INDEX IDX_17A55299CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, matiere_id INT NOT NULL, professeur_id INT NOT NULL, filiere_cycle_id INT NOT NULL, annee_id INT NOT NULL, semestre_id INT DEFAULT NULL, heurealloue INT NOT NULL, INDEX IDX_3DDCB9FFF46CD258 (matiere_id), INDEX IDX_3DDCB9FFBAB22EE9 (professeur_id), INDEX IDX_3DDCB9FF713D4CBA (filiere_cycle_id), INDEX IDX_3DDCB9FF543EC5F0 (annee_id), INDEX IDX_3DDCB9FF5577AFDB (semestre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reglement (id INT AUTO_INCREMENT NOT NULL, payement_method_id INT NOT NULL, payement_reason_id INT DEFAULT NULL, inscription_id INT NOT NULL, ontant_reglement INT NOT NULL, date_reglement DATETIME NOT NULL, INDEX IDX_EBE4C14C396979B3 (payement_method_id), INDEX IDX_EBE4C14C795A5546 (payement_reason_id), INDEX IDX_EBE4C14C5DAC5993 (inscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle_cours (id INT AUTO_INCREMENT NOT NULL, campus_id INT NOT NULL, nom_salle VARCHAR(150) NOT NULL, INDEX IDX_10CF8FF5AF5D55E1 (campus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE semestre (id INT AUTO_INCREMENT NOT NULL, nomsemestre VARCHAR(200) NOT NULL, datedebut DATE NOT NULL, datefin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE campus ADD CONSTRAINT FK_9D096811AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('ALTER TABLE emploi_temps ADD CONSTRAINT FK_50D1B05EDC304035 FOREIGN KEY (salle_id) REFERENCES salle_cours (id)');
        $this->addSql('ALTER TABLE emploi_temps ADD CONSTRAINT FK_50D1B05E62BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE filiere_cycle ADD CONSTRAINT FK_C9D69335180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE filiere_cycle ADD CONSTRAINT FK_C9D693355EC1162 FOREIGN KEY (cycle_id) REFERENCES cycle (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6112BB29C FOREIGN KEY (filierecycle_id) REFERENCES filiere_cycle (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A55299CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FFF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FFBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF713D4CBA FOREIGN KEY (filiere_cycle_id) REFERENCES filiere_cycle (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF5577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14C396979B3 FOREIGN KEY (payement_method_id) REFERENCES payement_method (id)');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14C795A5546 FOREIGN KEY (payement_reason_id) REFERENCES payement_reason (id)');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14C5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE salle_cours ADD CONSTRAINT FK_10CF8FF5AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campus DROP FOREIGN KEY FK_9D096811AF5D55E1');
        $this->addSql('ALTER TABLE emploi_temps DROP FOREIGN KEY FK_50D1B05EDC304035');
        $this->addSql('ALTER TABLE emploi_temps DROP FOREIGN KEY FK_50D1B05E62BB7AEE');
        $this->addSql('ALTER TABLE filiere_cycle DROP FOREIGN KEY FK_C9D69335180AA129');
        $this->addSql('ALTER TABLE filiere_cycle DROP FOREIGN KEY FK_C9D693355EC1162');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6112BB29C');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6543EC5F0');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6DDEAB1A3');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A55299CCF9E01E');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FFF46CD258');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FFBAB22EE9');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF713D4CBA');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF543EC5F0');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF5577AFDB');
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14C396979B3');
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14C795A5546');
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14C5DAC5993');
        $this->addSql('ALTER TABLE salle_cours DROP FOREIGN KEY FK_10CF8FF5AF5D55E1');
        $this->addSql('DROP TABLE annee');
        $this->addSql('DROP TABLE campus');
        $this->addSql('DROP TABLE cycle');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE emploi_temps');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE filiere');
        $this->addSql('DROP TABLE filiere_cycle');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE payement_method');
        $this->addSql('DROP TABLE payement_reason');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP TABLE reglement');
        $this->addSql('DROP TABLE salle_cours');
        $this->addSql('DROP TABLE semestre');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
