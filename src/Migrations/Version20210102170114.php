<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210102170114 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message_externe (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT NOT NULL, historique_id INT NOT NULL, contacts VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, type_message INT NOT NULL, INDEX IDX_A2622762A4AEAFEA (entreprise_id), UNIQUE INDEX UNIQ_A26227626128735E (historique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_externe ADD CONSTRAINT FK_A2622762A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES smartgestion_entreprise (id)');
        $this->addSql('ALTER TABLE message_externe ADD CONSTRAINT FK_A26227626128735E FOREIGN KEY (historique_id) REFERENCES smartgestion_historique (id)');
        $this->addSql('DROP TABLE migration_versions');
        $this->addSql('DROP TABLE smartgestion_entree');
        $this->addSql('DROP TABLE smartgestion_sortie');
        $this->addSql('ALTER TABLE smartgestion_entreprise ADD api_message VARCHAR(255) DEFAULT NULL, ADD message_1 VARCHAR(255) DEFAULT NULL, ADD message_2 VARCHAR(255) DEFAULT NULL, ADD message_3 VARCHAR(255) DEFAULT NULL, ADD message_4 VARCHAR(255) DEFAULT NULL, ADD message_5 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE migration_versions (version VARCHAR(14) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, executed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE smartgestion_entree (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, montant INT NOT NULL, objet VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, INDEX IDX_8423FE7F56CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE smartgestion_sortie (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, montant INT NOT NULL, objet VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, INDEX IDX_E19F5A2B56CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE smartgestion_entree ADD CONSTRAINT FK_8423FE7F56CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id)');
        $this->addSql('ALTER TABLE smartgestion_sortie ADD CONSTRAINT FK_E19F5A2B56CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id)');
        $this->addSql('DROP TABLE message_externe');
        $this->addSql('ALTER TABLE smartgestion_entreprise DROP api_message, DROP message_1, DROP message_2, DROP message_3, DROP message_4, DROP message_5');
    }
}
