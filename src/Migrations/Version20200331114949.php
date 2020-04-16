<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200331114949 extends AbstractMigration
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
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD316867B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE ingredients CHANGE recettes_id recettes_id INT DEFAULT NULL, CHANGE date_delete date_delete DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE preparations DROP INDEX UNIQ_A12709A43E2ED6D6, ADD INDEX IDX_A12709A43E2ED6D6 (recettes_id)');
        $this->addSql('ALTER TABLE preparations CHANGE date_delete date_delete DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE articles');
        $this->addSql('ALTER TABLE ingredients CHANGE recettes_id recettes_id INT DEFAULT NULL, CHANGE date_delete date_delete DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE preparations DROP INDEX IDX_A12709A43E2ED6D6, ADD UNIQUE INDEX UNIQ_A12709A43E2ED6D6 (recettes_id)');
        $this->addSql('ALTER TABLE preparations CHANGE date_delete date_delete DATETIME DEFAULT \'NULL\'');
    }
}
