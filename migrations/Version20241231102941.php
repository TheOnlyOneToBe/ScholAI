<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241231102941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annee_academique (id INT AUTO_INCREMENT NOT NULL, year_start DATE NOT NULL, year_end DATE NOT NULL, is_current TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE antecedent_academique (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, etablissement VARCHAR(255) NOT NULL, diplome VARCHAR(255) NOT NULL, matricule_diplome VARCHAR(255) NOT NULL, annee_obtention DATE NOT NULL, INDEX IDX_FFBDDD1EDDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bourse (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, annee_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, remise DOUBLE PRECISION DEFAULT NULL, INDEX IDX_DDC2BC1CDDEAB1A3 (etudiant_id), INDEX IDX_DDC2BC1C543EC5F0 (annee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campus (id INT AUTO_INCREMENT NOT NULL, nom_campus VARCHAR(150) NOT NULL, adresse_campus VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chef_departement (id INT AUTO_INCREMENT NOT NULL, professeur_id INT NOT NULL, departement_id INT NOT NULL, date_debut_mandat DATE NOT NULL, INDEX IDX_33F33071BAB22EE9 (professeur_id), INDEX IDX_33F33071CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, nom_cours VARCHAR(255) NOT NULL, descriptif VARCHAR(255) DEFAULT NULL, type_cours VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cycle (id INT AUTO_INCREMENT NOT NULL, nom_cycle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, nom_departement VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, sexe VARCHAR(10) NOT NULL, date_naissance DATE NOT NULL, adresse VARCHAR(255) NOT NULL, is_registration_allowed TINYINT(1) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, num_telephone VARCHAR(20) NOT NULL, lieu_naissance VARCHAR(255) DEFAULT NULL, nationalite VARCHAR(100) DEFAULT NULL, student_photo VARCHAR(255) DEFAULT NULL, cni VARCHAR(255) DEFAULT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME NOT NULL, UNIQUE INDEX UNIQ_717E22E3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, ue_id INT NOT NULL, semestre_id INT NOT NULL, type_id INT NOT NULL, date_debut DATE NOT NULL, temps_evaluation INT NOT NULL, statut VARCHAR(50) NOT NULL, INDEX IDX_1323A57562E883B1 (ue_id), INDEX IDX_1323A5755577AFDB (semestre_id), INDEX IDX_1323A575C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filiere (id INT AUTO_INCREMENT NOT NULL, nom_filiere VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filiere_cycle (id INT AUTO_INCREMENT NOT NULL, filiere_id INT NOT NULL, cycle_id INT NOT NULL, description VARCHAR(255) NOT NULL, frais_inscription DOUBLE PRECISION NOT NULL, montant_pension DOUBLE PRECISION NOT NULL, INDEX IDX_C9D69335180AA129 (filiere_id), INDEX IDX_C9D693355EC1162 (cycle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE impression_format (id INT AUTO_INCREMENT NOT NULL, nom_format VARCHAR(255) NOT NULL, largeur_page VARCHAR(255) NOT NULL, longueur_page DOUBLE PRECISION NOT NULL, description VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incident (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, description VARCHAR(255) NOT NULL, date_incident DATETIME NOT NULL, gravite VARCHAR(255) NOT NULL, type_incident VARCHAR(255) NOT NULL, INDEX IDX_3D03A11ADDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, filiere_cycle_id INT NOT NULL, semestre_id INT NOT NULL, annee_id INT NOT NULL, statut VARCHAR(50) NOT NULL, is_suspended TINYINT(1) NOT NULL, date_inscription DATE NOT NULL, INDEX IDX_5E90F6D6DDEAB1A3 (etudiant_id), INDEX IDX_5E90F6D6713D4CBA (filiere_cycle_id), INDEX IDX_5E90F6D65577AFDB (semestre_id), INDEX IDX_5E90F6D6543EC5F0 (annee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, evaluation_id INT NOT NULL, note_value DOUBLE PRECISION NOT NULL, INDEX IDX_CFBDFA14DDEAB1A3 (etudiant_id), INDEX IDX_CFBDFA14456C5646 (evaluation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payementmethod (id INT AUTO_INCREMENT NOT NULL, payement_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payementreason (id INT AUTO_INCREMENT NOT NULL, raison VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning_cours (id INT AUTO_INCREMENT NOT NULL, ue_id INT NOT NULL, sallecours_id INT NOT NULL, jour VARCHAR(16) NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, type_cours VARCHAR(255) NOT NULL, INDEX IDX_6C66360362E883B1 (ue_id), INDEX IDX_6C66360327B1F59C (sallecours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presence (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, ue_id INT NOT NULL, planning_cours_id INT NOT NULL, statut VARCHAR(50) NOT NULL, INDEX IDX_6977C7A5DDEAB1A3 (etudiant_id), INDEX IDX_6977C7A562E883B1 (ue_id), INDEX IDX_6977C7A549CA2E1D (planning_cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, departement_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, numero_telephone VARCHAR(255) NOT NULL, cni VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, nationalite VARCHAR(255) NOT NULL, sexe VARCHAR(10) NOT NULL, adresse VARCHAR(255) NOT NULL, photo_profil VARCHAR(255) DEFAULT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME NOT NULL, UNIQUE INDEX UNIQ_17A55299E7927C74 (email), UNIQUE INDEX UNIQ_17A552997AC033BE (cni), INDEX IDX_17A55299CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reglement (id INT AUTO_INCREMENT NOT NULL, inscription_id INT NOT NULL, libelle_reglement_id INT NOT NULL, payementmethod_id INT NOT NULL, montant_reglee DOUBLE PRECISION NOT NULL, datereglement DATE NOT NULL, INDEX IDX_EBE4C14C5DAC5993 (inscription_id), INDEX IDX_EBE4C14C8DC24FFD (libelle_reglement_id), INDEX IDX_EBE4C14CB98D1B72 (payementmethod_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom_role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle_cours (id INT AUTO_INCREMENT NOT NULL, campus_id INT DEFAULT NULL, nom_salle VARCHAR(255) NOT NULL, capacite INT DEFAULT NULL, INDEX IDX_10CF8FF5AF5D55E1 (campus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE semestre (id INT AUTO_INCREMENT NOT NULL, anneeacademique_id INT NOT NULL, num_semestre VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_71688FBCDF38FDCA (anneeacademique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tuteur_etudiant (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(10) NOT NULL, num_telephone VARCHAR(24) NOT NULL, type_tuteur VARCHAR(30) NOT NULL, INDEX IDX_3BFDB433DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_evaluation (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ue (id INT AUTO_INCREMENT NOT NULL, matiere_id INT NOT NULL, profeseur_id INT NOT NULL, semestre_id INT NOT NULL, volume_horaire INT NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_2E490A9BF46CD258 (matiere_id), INDEX IDX_2E490A9B82F2EA70 (profeseur_id), INDEX IDX_2E490A9B5577AFDB (semestre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, professeur_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, role_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, motdepasse VARCHAR(255) NOT NULL, numerotelephone VARCHAR(255) DEFAULT NULL, cni VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, lieu_naissance VARCHAR(255) DEFAULT NULL, sexe VARCHAR(10) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, profession VARCHAR(255) NOT NULL, photo_profil VARCHAR(255) DEFAULT NULL, date_creation DATE NOT NULL, date_modification DATE NOT NULL, INDEX IDX_1D1C63B3BAB22EE9 (professeur_id), INDEX IDX_1D1C63B3DDEAB1A3 (etudiant_id), INDEX IDX_1D1C63B3D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE antecedent_academique ADD CONSTRAINT FK_FFBDDD1EDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE bourse ADD CONSTRAINT FK_DDC2BC1CDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE bourse ADD CONSTRAINT FK_DDC2BC1C543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee_academique (id)');
        $this->addSql('ALTER TABLE chef_departement ADD CONSTRAINT FK_33F33071BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE chef_departement ADD CONSTRAINT FK_33F33071CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A57562E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5755577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575C54C8C93 FOREIGN KEY (type_id) REFERENCES type_evaluation (id)');
        $this->addSql('ALTER TABLE filiere_cycle ADD CONSTRAINT FK_C9D69335180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE filiere_cycle ADD CONSTRAINT FK_C9D693355EC1162 FOREIGN KEY (cycle_id) REFERENCES cycle (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11ADDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6713D4CBA FOREIGN KEY (filiere_cycle_id) REFERENCES filiere_cycle (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D65577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee_academique (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE planning_cours ADD CONSTRAINT FK_6C66360362E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE planning_cours ADD CONSTRAINT FK_6C66360327B1F59C FOREIGN KEY (sallecours_id) REFERENCES salle_cours (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A562E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A549CA2E1D FOREIGN KEY (planning_cours_id) REFERENCES planning_cours (id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A55299CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14C5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14C8DC24FFD FOREIGN KEY (libelle_reglement_id) REFERENCES payementreason (id)');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14CB98D1B72 FOREIGN KEY (payementmethod_id) REFERENCES payementmethod (id)');
        $this->addSql('ALTER TABLE salle_cours ADD CONSTRAINT FK_10CF8FF5AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('ALTER TABLE semestre ADD CONSTRAINT FK_71688FBCDF38FDCA FOREIGN KEY (anneeacademique_id) REFERENCES annee_academique (id)');
        $this->addSql('ALTER TABLE tuteur_etudiant ADD CONSTRAINT FK_3BFDB433DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE ue ADD CONSTRAINT FK_2E490A9BF46CD258 FOREIGN KEY (matiere_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE ue ADD CONSTRAINT FK_2E490A9B82F2EA70 FOREIGN KEY (profeseur_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE ue ADD CONSTRAINT FK_2E490A9B5577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE antecedent_academique DROP FOREIGN KEY FK_FFBDDD1EDDEAB1A3');
        $this->addSql('ALTER TABLE bourse DROP FOREIGN KEY FK_DDC2BC1CDDEAB1A3');
        $this->addSql('ALTER TABLE bourse DROP FOREIGN KEY FK_DDC2BC1C543EC5F0');
        $this->addSql('ALTER TABLE chef_departement DROP FOREIGN KEY FK_33F33071BAB22EE9');
        $this->addSql('ALTER TABLE chef_departement DROP FOREIGN KEY FK_33F33071CCF9E01E');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A57562E883B1');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5755577AFDB');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575C54C8C93');
        $this->addSql('ALTER TABLE filiere_cycle DROP FOREIGN KEY FK_C9D69335180AA129');
        $this->addSql('ALTER TABLE filiere_cycle DROP FOREIGN KEY FK_C9D693355EC1162');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11ADDEAB1A3');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6DDEAB1A3');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6713D4CBA');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D65577AFDB');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6543EC5F0');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14DDEAB1A3');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14456C5646');
        $this->addSql('ALTER TABLE planning_cours DROP FOREIGN KEY FK_6C66360362E883B1');
        $this->addSql('ALTER TABLE planning_cours DROP FOREIGN KEY FK_6C66360327B1F59C');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5DDEAB1A3');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A562E883B1');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A549CA2E1D');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A55299CCF9E01E');
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14C5DAC5993');
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14C8DC24FFD');
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14CB98D1B72');
        $this->addSql('ALTER TABLE salle_cours DROP FOREIGN KEY FK_10CF8FF5AF5D55E1');
        $this->addSql('ALTER TABLE semestre DROP FOREIGN KEY FK_71688FBCDF38FDCA');
        $this->addSql('ALTER TABLE tuteur_etudiant DROP FOREIGN KEY FK_3BFDB433DDEAB1A3');
        $this->addSql('ALTER TABLE ue DROP FOREIGN KEY FK_2E490A9BF46CD258');
        $this->addSql('ALTER TABLE ue DROP FOREIGN KEY FK_2E490A9B82F2EA70');
        $this->addSql('ALTER TABLE ue DROP FOREIGN KEY FK_2E490A9B5577AFDB');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3BAB22EE9');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DDEAB1A3');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3D60322AC');
        $this->addSql('DROP TABLE annee_academique');
        $this->addSql('DROP TABLE antecedent_academique');
        $this->addSql('DROP TABLE bourse');
        $this->addSql('DROP TABLE campus');
        $this->addSql('DROP TABLE chef_departement');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE cycle');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE filiere');
        $this->addSql('DROP TABLE filiere_cycle');
        $this->addSql('DROP TABLE impression_format');
        $this->addSql('DROP TABLE incident');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE payementmethod');
        $this->addSql('DROP TABLE payementreason');
        $this->addSql('DROP TABLE planning_cours');
        $this->addSql('DROP TABLE presence');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE reglement');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE salle_cours');
        $this->addSql('DROP TABLE semestre');
        $this->addSql('DROP TABLE tuteur_etudiant');
        $this->addSql('DROP TABLE type_evaluation');
        $this->addSql('DROP TABLE ue');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
