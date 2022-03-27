<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309124709 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, nom_activite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE destination (id INT AUTO_INCREMENT NOT NULL, pays VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, destination_id INT NOT NULL, activites_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, nom_offre VARCHAR(255) NOT NULL, prix_offre INT NOT NULL, image VARCHAR(255) NOT NULL, nbdevues INT NOT NULL, INDEX IDX_AF86866F816C6140 (destination_id), INDEX IDX_AF86866F5B8C31B7 (activites_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_user (offre_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_CFC1683D4CC8505A (offre_id), INDEX IDX_CFC1683DA76ED395 (user_id), PRIMARY KEY(offre_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, numero INT NOT NULL, role TINYINT(1) NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F816C6140 FOREIGN KEY (destination_id) REFERENCES destination (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F5B8C31B7 FOREIGN KEY (activites_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE offre_user ADD CONSTRAINT FK_CFC1683D4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_user ADD CONSTRAINT FK_CFC1683DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F5B8C31B7');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F816C6140');
        $this->addSql('ALTER TABLE offre_user DROP FOREIGN KEY FK_CFC1683D4CC8505A');
        $this->addSql('ALTER TABLE offre_user DROP FOREIGN KEY FK_CFC1683DA76ED395');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE destination');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE offre_user');
        $this->addSql('DROP TABLE user');
    }
}
