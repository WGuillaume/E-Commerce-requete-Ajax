<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221221100155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, useradresse_id INT DEFAULT NULL, numero INT NOT NULL, rue VARCHAR(255) NOT NULL, cp INT NOT NULL, ville VARCHAR(255) NOT NULL, complement VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_C35F08169BF0A5 (useradresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, usercommande_id INT DEFAULT NULL, adresse_livraison_id INT DEFAULT NULL, adresse_facture_id INT DEFAULT NULL, date DATE NOT NULL, payee TINYINT(1) NOT NULL, retrait TINYINT(1) NOT NULL, INDEX IDX_6EEAA67D46C618C0 (usercommande_id), INDEX IDX_6EEAA67DBE2F0A35 (adresse_livraison_id), INDEX IDX_6EEAA67D10309E7F (adresse_facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moto (id INT AUTO_INCREMENT NOT NULL, marque_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, km INT NOT NULL, prix INT NOT NULL, date DATE NOT NULL, puissance INT NOT NULL, INDEX IDX_3DDDBCE44827B9B2 (marque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moto_panier (id INT AUTO_INCREMENT NOT NULL, moto_id INT DEFAULT NULL, panier_id INT DEFAULT NULL, quantite INT NOT NULL, total INT NOT NULL, INDEX IDX_343C20EF78B8F2AC (moto_id), INDEX IDX_343C20EFF77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, userpanier_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, date DATE NOT NULL, total INT NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_24CC0DF23930331C (userpanier_id), UNIQUE INDEX UNIQ_24CC0DF282EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, moto_id INT DEFAULT NULL, lien VARCHAR(255) NOT NULL, INDEX IDX_14B7841878B8F2AC (moto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F08169BF0A5 FOREIGN KEY (useradresse_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D46C618C0 FOREIGN KEY (usercommande_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DBE2F0A35 FOREIGN KEY (adresse_livraison_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D10309E7F FOREIGN KEY (adresse_facture_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE moto ADD CONSTRAINT FK_3DDDBCE44827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE moto_panier ADD CONSTRAINT FK_343C20EF78B8F2AC FOREIGN KEY (moto_id) REFERENCES moto (id)');
        $this->addSql('ALTER TABLE moto_panier ADD CONSTRAINT FK_343C20EFF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF23930331C FOREIGN KEY (userpanier_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF282EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841878B8F2AC FOREIGN KEY (moto_id) REFERENCES moto (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F08169BF0A5');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D46C618C0');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DBE2F0A35');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D10309E7F');
        $this->addSql('ALTER TABLE moto DROP FOREIGN KEY FK_3DDDBCE44827B9B2');
        $this->addSql('ALTER TABLE moto_panier DROP FOREIGN KEY FK_343C20EF78B8F2AC');
        $this->addSql('ALTER TABLE moto_panier DROP FOREIGN KEY FK_343C20EFF77D927C');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF23930331C');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF282EA2E54');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B7841878B8F2AC');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE moto');
        $this->addSql('DROP TABLE moto_panier');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
