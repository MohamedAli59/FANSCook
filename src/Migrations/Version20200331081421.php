<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200331081421 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE preparations ADD recettes_id INT NOT NULL, CHANGE date_delete date_delete DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE preparations ADD CONSTRAINT FK_A12709A43E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A12709A43E2ED6D6 ON preparations (recettes_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE preparations DROP FOREIGN KEY FK_A12709A43E2ED6D6');
        $this->addSql('DROP INDEX UNIQ_A12709A43E2ED6D6 ON preparations');
        $this->addSql('ALTER TABLE preparations DROP recettes_id, CHANGE date_delete date_delete DATETIME DEFAULT \'NULL\'');
    }
}
