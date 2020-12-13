<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201211064606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Activite (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', groupe_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, dateDebut VARCHAR(255) DEFAULT NULL, dateFin VARCHAR(255) DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, situation LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, latittude VARCHAR(255) DEFAULT NULL, longetude VARCHAR(255) DEFAULT NULL, nomProprietaire VARCHAR(255) DEFAULT NULL, fonctionProprietaire VARCHAR(255) DEFAULT NULL, contactProprietaire VARCHAR(255) DEFAULT NULL, autorisation VARCHAR(255) DEFAULT NULL, niveau VARCHAR(255) DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, annee VARCHAR(255) DEFAULT NULL, INDEX IDX_410337437A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Activite ADD CONSTRAINT FK_410337437A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE User CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Activite');
        $this->addSql('ALTER TABLE User CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
