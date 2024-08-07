<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200623153026 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE smartgestion_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, text_password VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1F0BFF23F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smartgestion_agent (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, type_piece VARCHAR(255) NOT NULL, numero_piece VARCHAR(255) NOT NULL, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, INDEX IDX_8B7E8CF256CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smartgestion_article (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, user_del_id INT NOT NULL, user_val_id INT NOT NULL, image VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, pu_vente INT NOT NULL, pu_achat INT NOT NULL, sku VARCHAR(255) DEFAULT NULL, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, etat_proprio TINYINT(1) NOT NULL, nom_proprio VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_FDE8C49FF9038C4 (sku), INDEX IDX_FDE8C49F56CECB9A (user_add_id), INDEX IDX_FDE8C49FFED75B76 (user_del_id), INDEX IDX_FDE8C49F45495E26 (user_val_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smartgestion_commande (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, agent_livreur_id INT DEFAULT NULL, user_montant_id INT DEFAULT NULL, type_commande VARCHAR(255) NOT NULL, nom_client VARCHAR(255) NOT NULL, numero_client VARCHAR(255) DEFAULT NULL, lieu_livraison VARCHAR(255) DEFAULT NULL, frais_livraison INT DEFAULT NULL, montant_recu INT DEFAULT NULL, sku VARCHAR(255) NOT NULL, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, date_livraison DATETIME DEFAULT NULL, etat_livraison TINYINT(1) NOT NULL, date_retour DATETIME DEFAULT NULL, etat_retour TINYINT(1) NOT NULL, INDEX IDX_AA743E0F56CECB9A (user_add_id), INDEX IDX_AA743E0F8922B60E (agent_livreur_id), INDEX IDX_AA743E0FA69F17A4 (user_montant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smartgestion_commande_article (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, commande_id INT NOT NULL, quantite INT NOT NULL, pu_vente INT NOT NULL, pu_achat INT NOT NULL, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, INDEX IDX_FD2AEB587294869C (article_id), INDEX IDX_FD2AEB5882EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smartgestion_credit_article (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, user_add_id INT NOT NULL, quantite INT NOT NULL, objet VARCHAR(255) DEFAULT NULL, date_add DATETIME DEFAULT NULL, INDEX IDX_541B01597294869C (article_id), INDEX IDX_541B015956CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smartgestion_debit_article (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, user_add_id INT NOT NULL, quantite INT NOT NULL, objet VARCHAR(255) DEFAULT NULL, ref_article VARCHAR(255) DEFAULT NULL, date_add DATETIME DEFAULT NULL, etat_defectueux TINYINT(1) NOT NULL, INDEX IDX_4967B2EE7294869C (article_id), INDEX IDX_4967B2EE56CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smartgestion_entree (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, montant INT NOT NULL, objet VARCHAR(255) NOT NULL, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, INDEX IDX_8423FE7F56CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE smartgestion_sortie (id INT AUTO_INCREMENT NOT NULL, user_add_id INT NOT NULL, montant INT NOT NULL, objet VARCHAR(255) NOT NULL, date_add DATETIME DEFAULT NULL, date_del DATETIME DEFAULT NULL, etat_val TINYINT(1) NOT NULL, etat_del TINYINT(1) NOT NULL, INDEX IDX_E19F5A2B56CECB9A (user_add_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE smartgestion_agent ADD CONSTRAINT FK_8B7E8CF256CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id)');
        $this->addSql('ALTER TABLE smartgestion_article ADD CONSTRAINT FK_FDE8C49F56CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id)');
        $this->addSql('ALTER TABLE smartgestion_article ADD CONSTRAINT FK_FDE8C49FFED75B76 FOREIGN KEY (user_del_id) REFERENCES smartgestion_user (id)');
        $this->addSql('ALTER TABLE smartgestion_article ADD CONSTRAINT FK_FDE8C49F45495E26 FOREIGN KEY (user_val_id) REFERENCES smartgestion_user (id)');
        $this->addSql('ALTER TABLE smartgestion_commande ADD CONSTRAINT FK_AA743E0F56CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id)');
        $this->addSql('ALTER TABLE smartgestion_commande ADD CONSTRAINT FK_AA743E0F8922B60E FOREIGN KEY (agent_livreur_id) REFERENCES smartgestion_agent (id)');
        $this->addSql('ALTER TABLE smartgestion_commande ADD CONSTRAINT FK_AA743E0FA69F17A4 FOREIGN KEY (user_montant_id) REFERENCES smartgestion_user (id)');
        $this->addSql('ALTER TABLE smartgestion_commande_article ADD CONSTRAINT FK_FD2AEB587294869C FOREIGN KEY (article_id) REFERENCES smartgestion_article (id)');
        $this->addSql('ALTER TABLE smartgestion_commande_article ADD CONSTRAINT FK_FD2AEB5882EA2E54 FOREIGN KEY (commande_id) REFERENCES smartgestion_commande (id)');
        $this->addSql('ALTER TABLE smartgestion_credit_article ADD CONSTRAINT FK_541B01597294869C FOREIGN KEY (article_id) REFERENCES smartgestion_article (id)');
        $this->addSql('ALTER TABLE smartgestion_credit_article ADD CONSTRAINT FK_541B015956CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id)');
        $this->addSql('ALTER TABLE smartgestion_debit_article ADD CONSTRAINT FK_4967B2EE7294869C FOREIGN KEY (article_id) REFERENCES smartgestion_article (id)');
        $this->addSql('ALTER TABLE smartgestion_debit_article ADD CONSTRAINT FK_4967B2EE56CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id)');
        $this->addSql('ALTER TABLE smartgestion_entree ADD CONSTRAINT FK_8423FE7F56CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id)');
        $this->addSql('ALTER TABLE smartgestion_sortie ADD CONSTRAINT FK_E19F5A2B56CECB9A FOREIGN KEY (user_add_id) REFERENCES smartgestion_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE smartgestion_agent DROP FOREIGN KEY FK_8B7E8CF256CECB9A');
        $this->addSql('ALTER TABLE smartgestion_article DROP FOREIGN KEY FK_FDE8C49F56CECB9A');
        $this->addSql('ALTER TABLE smartgestion_article DROP FOREIGN KEY FK_FDE8C49FFED75B76');
        $this->addSql('ALTER TABLE smartgestion_article DROP FOREIGN KEY FK_FDE8C49F45495E26');
        $this->addSql('ALTER TABLE smartgestion_commande DROP FOREIGN KEY FK_AA743E0F56CECB9A');
        $this->addSql('ALTER TABLE smartgestion_commande DROP FOREIGN KEY FK_AA743E0FA69F17A4');
        $this->addSql('ALTER TABLE smartgestion_credit_article DROP FOREIGN KEY FK_541B015956CECB9A');
        $this->addSql('ALTER TABLE smartgestion_debit_article DROP FOREIGN KEY FK_4967B2EE56CECB9A');
        $this->addSql('ALTER TABLE smartgestion_entree DROP FOREIGN KEY FK_8423FE7F56CECB9A');
        $this->addSql('ALTER TABLE smartgestion_sortie DROP FOREIGN KEY FK_E19F5A2B56CECB9A');
        $this->addSql('ALTER TABLE smartgestion_commande DROP FOREIGN KEY FK_AA743E0F8922B60E');
        $this->addSql('ALTER TABLE smartgestion_commande_article DROP FOREIGN KEY FK_FD2AEB587294869C');
        $this->addSql('ALTER TABLE smartgestion_credit_article DROP FOREIGN KEY FK_541B01597294869C');
        $this->addSql('ALTER TABLE smartgestion_debit_article DROP FOREIGN KEY FK_4967B2EE7294869C');
        $this->addSql('ALTER TABLE smartgestion_commande_article DROP FOREIGN KEY FK_FD2AEB5882EA2E54');
        $this->addSql('DROP TABLE smartgestion_user');
        $this->addSql('DROP TABLE smartgestion_agent');
        $this->addSql('DROP TABLE smartgestion_article');
        $this->addSql('DROP TABLE smartgestion_commande');
        $this->addSql('DROP TABLE smartgestion_commande_article');
        $this->addSql('DROP TABLE smartgestion_credit_article');
        $this->addSql('DROP TABLE smartgestion_debit_article');
        $this->addSql('DROP TABLE smartgestion_entree');
        $this->addSql('DROP TABLE smartgestion_sortie');
    }
}
