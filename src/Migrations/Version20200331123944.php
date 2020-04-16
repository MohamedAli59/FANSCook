<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200331123944 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date_add DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, activate TINYINT(1) NOT NULL, INDEX IDX_BFDD316867B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date_add DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATETIME NOT NULL, activate TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, recettes_id INT NOT NULL, avis LONGTEXT NOT NULL, date_add DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, activate TINYINT(1) NOT NULL, INDEX IDX_D9BEC0C467B3B43D (users_id), INDEX IDX_D9BEC0C43E2ED6D6 (recettes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, recettes_id INT DEFAULT NULL, date_add DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, activate TINYINT(1) NOT NULL, INDEX IDX_8933C43267B3B43D (users_id), INDEX IDX_8933C4323E2ED6D6 (recettes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredients (id INT AUTO_INCREMENT NOT NULL, recettes_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, quantite VARCHAR(255) NOT NULL, date_add DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, activate TINYINT(1) NOT NULL, INDEX IDX_4B60114F3E2ED6D6 (recettes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, objet VARCHAR(255) NOT NULL, lu TINYINT(1) NOT NULL, message LONGTEXT NOT NULL, date_add DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, INDEX IDX_DB021E9667B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notes (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, recettes_id INT DEFAULT NULL, note INT DEFAULT NULL, date_add DATETIME NOT NULL, date_update DATETIME DEFAULT NULL, activate TINYINT(1) NOT NULL, INDEX IDX_11BA68C67B3B43D (users_id), INDEX IDX_11BA68C3E2ED6D6 (recettes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE preparations (id INT AUTO_INCREMENT NOT NULL, recettes_id INT NOT NULL, etapes VARCHAR(255) NOT NULL, ordres SMALLINT NOT NULL, date_add DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, activate TINYINT(1) NOT NULL, INDEX IDX_A12709A43E2ED6D6 (recettes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recettes (id INT AUTO_INCREMENT NOT NULL, categories_id INT NOT NULL, users_id INT NOT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, top_recette TINYINT(1) NOT NULL, note_moyenne DOUBLE PRECISION NOT NULL, date_add DATETIME NOT NULL, datetime DATETIME NOT NULL, date_delete DATETIME NOT NULL, activate TINYINT(1) NOT NULL, INDEX IDX_EB48E72CA21214B7 (categories_id), INDEX IDX_EB48E72C67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, date_add DATETIME NOT NULL, date_update VARCHAR(255) NOT NULL, date_delete DATETIME NOT NULL, activate TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD316867B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C467B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C43E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C43267B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4323E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id)');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT FK_4B60114F3E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9667B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C3E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id)');
        $this->addSql('ALTER TABLE preparations ADD CONSTRAINT FK_A12709A43E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id)');
        $this->addSql('ALTER TABLE recettes ADD CONSTRAINT FK_EB48E72CA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE recettes ADD CONSTRAINT FK_EB48E72C67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recettes DROP FOREIGN KEY FK_EB48E72CA21214B7');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C43E2ED6D6');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4323E2ED6D6');
        $this->addSql('ALTER TABLE ingredients DROP FOREIGN KEY FK_4B60114F3E2ED6D6');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68C3E2ED6D6');
        $this->addSql('ALTER TABLE preparations DROP FOREIGN KEY FK_A12709A43E2ED6D6');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD316867B3B43D');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C467B3B43D');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C43267B3B43D');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E9667B3B43D');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68C67B3B43D');
        $this->addSql('ALTER TABLE recettes DROP FOREIGN KEY FK_EB48E72C67B3B43D');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP TABLE preparations');
        $this->addSql('DROP TABLE recettes');
        $this->addSql('DROP TABLE users');
    }
}
