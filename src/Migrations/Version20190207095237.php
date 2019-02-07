<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190207095237 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE titre');
        $this->addSql('ALTER TABLE livre ADD emprunteur_id INT NOT NULL, ADD category_id INT NOT NULL, DROP titre');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99F0840037 FOREIGN KEY (emprunteur_id) REFERENCES emprunteur (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F9912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_AC634F99F0840037 ON livre (emprunteur_id)');
        $this->addSql('CREATE INDEX IDX_AC634F9912469DE2 ON livre (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE titre (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99F0840037');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F9912469DE2');
        $this->addSql('DROP INDEX IDX_AC634F99F0840037 ON livre');
        $this->addSql('DROP INDEX IDX_AC634F9912469DE2 ON livre');
        $this->addSql('ALTER TABLE livre ADD titre VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP emprunteur_id, DROP category_id');
    }
}
