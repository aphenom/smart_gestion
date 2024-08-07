<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200703213622 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE smartgestion_autre_transaction (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, type_transaction VARCHAR(255) NOT NULL, montant INT NOT NULL, objet VARCHAR(255) NOT NULL, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, INDEX IDX_4C8FC60156CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE smartgestion_autre_transaction ADD CONSTRAINT FK_4C8FC60156CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id)');
        $this->addSql('DROP TABLE migration_versions');
        $this->addSql('DROP TABLE smartgestion_entree');
        $this->addSql('DROP TABLE smartgestion_sortie');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE migration_versions (version VARCHAR(14) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, executed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE smartgestion_entree (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, montant INT NOT NULL, objet VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, INDEX IDX_8423FE7F56CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE smartgestion_sortie (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, montant INT NOT NULL, objet VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, INDEX IDX_E19F5A2B56CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE smartgestion_entree ADD CONSTRAINT FK_8423FE7F56CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE smartgestion_sortie ADD CONSTRAINT FK_E19F5A2B56CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE smartgestion_autre_transaction');
    }
}
