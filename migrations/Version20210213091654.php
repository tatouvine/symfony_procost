<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210213091654 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sto_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B0EC51E2F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sto_comment ADD sto_user_id INT DEFAULT NULL, DROP pseudo');
        $this->addSql('ALTER TABLE sto_comment ADD CONSTRAINT FK_F52182F1C63B0308 FOREIGN KEY (sto_user_id) REFERENCES sto_user (id)');
        $this->addSql('CREATE INDEX IDX_F52182F1C63B0308 ON sto_comment (sto_user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sto_comment DROP FOREIGN KEY FK_F52182F1C63B0308');
        $this->addSql('DROP TABLE sto_user');
        $this->addSql('DROP INDEX IDX_F52182F1C63B0308 ON sto_comment');
        $this->addSql('ALTER TABLE sto_comment ADD pseudo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP sto_user_id');
    }
}
