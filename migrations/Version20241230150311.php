<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241230150311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payementmethod (id INT AUTO_INCREMENT NOT NULL, payement_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payementreason (id INT AUTO_INCREMENT NOT NULL, raison VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reglement (id INT AUTO_INCREMENT NOT NULL, inscription_id INT NOT NULL, libelle_reglement_id INT NOT NULL, payementmethod_id INT NOT NULL, montant_reglee DOUBLE PRECISION NOT NULL, datereglement DATE NOT NULL, INDEX IDX_EBE4C14C5DAC5993 (inscription_id), INDEX IDX_EBE4C14C8DC24FFD (libelle_reglement_id), INDEX IDX_EBE4C14CB98D1B72 (payementmethod_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14C5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14C8DC24FFD FOREIGN KEY (libelle_reglement_id) REFERENCES payementreason (id)');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14CB98D1B72 FOREIGN KEY (payementmethod_id) REFERENCES payementmethod (id)');
        $this->addSql('ALTER TABLE professeur CHANGE numero_telephone numero_telephone VARCHAR(255) NOT NULL, CHANGE date_naissance date_naissance DATE NOT NULL, CHANGE nationalite nationalite VARCHAR(255) NOT NULL, CHANGE sexe sexe VARCHAR(10) NOT NULL, CHANGE photo_profil photo_profil VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_17A552997AC033BE ON professeur (cni)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14C5DAC5993');
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14C8DC24FFD');
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14CB98D1B72');
        $this->addSql('DROP TABLE payementmethod');
        $this->addSql('DROP TABLE payementreason');
        $this->addSql('DROP TABLE reglement');
        $this->addSql('DROP INDEX UNIQ_17A552997AC033BE ON professeur');
        $this->addSql('ALTER TABLE professeur CHANGE numero_telephone numero_telephone VARCHAR(255) DEFAULT NULL, CHANGE date_naissance date_naissance DATE DEFAULT NULL, CHANGE nationalite nationalite VARCHAR(255) DEFAULT NULL, CHANGE sexe sexe VARCHAR(10) DEFAULT NULL, CHANGE photo_profil photo_profil VARCHAR(255) NOT NULL');
    }
}
