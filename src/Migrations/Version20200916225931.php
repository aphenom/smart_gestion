<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200916225931 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECA4AEAFEA');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE migration_versions');
        $this->addSql('DROP TABLE smartgestion_entree');
        $this->addSql('DROP TABLE smartgestion_sortie');
        $this->addSql('ALTER TABLE smartgestion_article ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, logo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, contact VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, user_id INT NOT NULL, entreprise_id INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_EDBFD5EC82EA2E54 (commande_id), INDEX IDX_EDBFD5ECA4AEAFEA (entreprise_id), INDEX IDX_EDBFD5ECA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE migration_versions (version VARCHAR(14) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, executed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE smartgestion_entree (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, montant INT NOT NULL, objet VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, INDEX IDX_8423FE7F56CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE smartgestion_sortie (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, montant INT NOT NULL, objet VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, INDEX IDX_E19F5A2B56CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC82EA2E54 FOREIGN KEY (commande_id) REFERENCES smartgestion_commande (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECA76ED395 FOREIGN KEY (user_id) REFERENCES smartgestion_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE smartgestion_entree ADD CONSTRAINT FK_8423FE7F56CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE smartgestion_sortie ADD CONSTRAINT FK_E19F5A2B56CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE smartgestion_article DROP updated_at');
    }
}
