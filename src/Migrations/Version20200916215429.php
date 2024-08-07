<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200916215429 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, user_id INT NOT NULL, entreprise_id INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_EDBFD5EC82EA2E54 (commande_id), INDEX IDX_EDBFD5ECA76ED395 (user_id), INDEX IDX_EDBFD5ECA4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC82EA2E54 FOREIGN KEY (commande_id) REFERENCES smartgestion_commande (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECA76ED395 FOREIGN KEY (user_id) REFERENCES smartgestion_user (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('DROP TABLE migration_versions');
        $this->addSql('DROP TABLE smartgestion_entree');
        $this->addSql('DROP TABLE smartgestion_sortie');
        $this->addSql('ALTER TABLE smartgestion_agent ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE smartgestion_agent ADD CONSTRAINT FK_8B7E8CF2A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_8B7E8CF2A4AEAFEA ON smartgestion_agent (entreprise_id)');
        $this->addSql('ALTER TABLE smartgestion_article ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE smartgestion_article ADD CONSTRAINT FK_FDE8C49FA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_FDE8C49FA4AEAFEA ON smartgestion_article (entreprise_id)');
        $this->addSql('ALTER TABLE smartgestion_autre_transaction ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE smartgestion_autre_transaction ADD CONSTRAINT FK_4C8FC601A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_4C8FC601A4AEAFEA ON smartgestion_autre_transaction (entreprise_id)');
        $this->addSql('ALTER TABLE smartgestion_commande ADD entreprise_id INT DEFAULT NULL, ADD etat_relance TINYINT(1) NOT NULL, ADD date_relance DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE smartgestion_commande ADD CONSTRAINT FK_AA743E0FA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_AA743E0FA4AEAFEA ON smartgestion_commande (entreprise_id)');
        $this->addSql('ALTER TABLE smartgestion_commande_article ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE smartgestion_commande_article ADD CONSTRAINT FK_FD2AEB58A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_FD2AEB58A4AEAFEA ON smartgestion_commande_article (entreprise_id)');
        $this->addSql('ALTER TABLE smartgestion_credit_article ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE smartgestion_credit_article ADD CONSTRAINT FK_541B0159A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_541B0159A4AEAFEA ON smartgestion_credit_article (entreprise_id)');
        $this->addSql('ALTER TABLE smartgestion_debit_article ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE smartgestion_debit_article ADD CONSTRAINT FK_4967B2EEA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_4967B2EEA4AEAFEA ON smartgestion_debit_article (entreprise_id)');
        $this->addSql('ALTER TABLE smartgestion_user ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE smartgestion_user ADD CONSTRAINT FK_1F0BFF23A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_1F0BFF23A4AEAFEA ON smartgestion_user (entreprise_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECA4AEAFEA');
        $this->addSql('ALTER TABLE smartgestion_agent DROP FOREIGN KEY FK_8B7E8CF2A4AEAFEA');
        $this->addSql('ALTER TABLE smartgestion_article DROP FOREIGN KEY FK_FDE8C49FA4AEAFEA');
        $this->addSql('ALTER TABLE smartgestion_autre_transaction DROP FOREIGN KEY FK_4C8FC601A4AEAFEA');
        $this->addSql('ALTER TABLE smartgestion_commande DROP FOREIGN KEY FK_AA743E0FA4AEAFEA');
        $this->addSql('ALTER TABLE smartgestion_commande_article DROP FOREIGN KEY FK_FD2AEB58A4AEAFEA');
        $this->addSql('ALTER TABLE smartgestion_credit_article DROP FOREIGN KEY FK_541B0159A4AEAFEA');
        $this->addSql('ALTER TABLE smartgestion_debit_article DROP FOREIGN KEY FK_4967B2EEA4AEAFEA');
        $this->addSql('ALTER TABLE smartgestion_user DROP FOREIGN KEY FK_1F0BFF23A4AEAFEA');
        $this->addSql('CREATE TABLE migration_versions (version VARCHAR(14) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, executed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE smartgestion_entree (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, montant INT NOT NULL, objet VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, INDEX IDX_8423FE7F56CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE smartgestion_sortie (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, montant INT NOT NULL, objet VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, INDEX IDX_E19F5A2B56CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE smartgestion_entree ADD CONSTRAINT FK_8423FE7F56CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE smartgestion_sortie ADD CONSTRAINT FK_E19F5A2B56CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP INDEX IDX_8B7E8CF2A4AEAFEA ON smartgestion_agent');
        $this->addSql('ALTER TABLE smartgestion_agent DROP entreprise_id');
        $this->addSql('DROP INDEX IDX_FDE8C49FA4AEAFEA ON smartgestion_article');
        $this->addSql('ALTER TABLE smartgestion_article DROP entreprise_id');
        $this->addSql('DROP INDEX IDX_4C8FC601A4AEAFEA ON smartgestion_autre_transaction');
        $this->addSql('ALTER TABLE smartgestion_autre_transaction DROP entreprise_id');
        $this->addSql('DROP INDEX IDX_AA743E0FA4AEAFEA ON smartgestion_commande');
        $this->addSql('ALTER TABLE smartgestion_commande DROP entreprise_id, DROP etat_relance, DROP date_relance');
        $this->addSql('DROP INDEX IDX_FD2AEB58A4AEAFEA ON smartgestion_commande_article');
        $this->addSql('ALTER TABLE smartgestion_commande_article DROP entreprise_id');
        $this->addSql('DROP INDEX IDX_541B0159A4AEAFEA ON smartgestion_credit_article');
        $this->addSql('ALTER TABLE smartgestion_credit_article DROP entreprise_id');
        $this->addSql('DROP INDEX IDX_4967B2EEA4AEAFEA ON smartgestion_debit_article');
        $this->addSql('ALTER TABLE smartgestion_debit_article DROP entreprise_id');
        $this->addSql('DROP INDEX IDX_1F0BFF23A4AEAFEA ON smartgestion_user');
        $this->addSql('ALTER TABLE smartgestion_user DROP entreprise_id');
    }
}
