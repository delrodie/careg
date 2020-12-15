<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201214120504 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Activite (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, dateDebut VARCHAR(255) DEFAULT NULL, dateFin VARCHAR(255) DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, situation LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, latittude VARCHAR(255) DEFAULT NULL, longetude VARCHAR(255) DEFAULT NULL, nomProprietaire VARCHAR(255) DEFAULT NULL, fonctionProprietaire VARCHAR(255) DEFAULT NULL, contactProprietaire VARCHAR(255) DEFAULT NULL, autorisation VARCHAR(255) DEFAULT NULL, niveau VARCHAR(255) DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, annee VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_410337437A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Participant (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, activite_id INT DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, carte VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenoms VARCHAR(255) DEFAULT NULL, dateNaissance VARCHAR(255) DEFAULT NULL, lieuNaissance VARCHAR(255) DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, branche VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, urgance VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL, INDEX IDX_5103E4C67A45358C (groupe_id), INDEX IDX_5103E4C69B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Activite ADD CONSTRAINT FK_410337437A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE Participant ADD CONSTRAINT FK_5103E4C67A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE Participant ADD CONSTRAINT FK_5103E4C69B0F88B1 FOREIGN KEY (activite_id) REFERENCES Activite (id)');
        $this->addSql('ALTER TABLE User CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Participant DROP FOREIGN KEY FK_5103E4C69B0F88B1');
        $this->addSql('DROP TABLE Activite');
        $this->addSql('DROP TABLE Participant');
        $this->addSql('ALTER TABLE User CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
