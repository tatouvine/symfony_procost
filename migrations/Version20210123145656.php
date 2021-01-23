<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210123145656 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sto_product ADD CONSTRAINT FK_B21FD430CA2A6A21 FOREIGN KEY (sto_brand_id) REFERENCES sto_brand (id)');
        $this->addSql('CREATE INDEX IDX_B21FD430CA2A6A21 ON sto_product (sto_brand_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sto_product DROP FOREIGN KEY FK_B21FD430CA2A6A21');
        $this->addSql('DROP INDEX IDX_B21FD430CA2A6A21 ON sto_product');
    }
}
