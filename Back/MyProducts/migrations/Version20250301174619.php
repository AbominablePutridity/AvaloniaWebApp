<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250301174619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actor (id UUID NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN actor.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE material (id UUID NOT NULL, product_id UUID NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(5000) NOT NULL, amount_of INT NOT NULL, salary INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CBE75954584665A ON material (product_id)');
        $this->addSql('COMMENT ON COLUMN material.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN material.product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE product (id UUID NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(5000) NOT NULL, size VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN product.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE raiting (id UUID NOT NULL, actor_id UUID NOT NULL, product_id UUID NOT NULL, amount_of_stars INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3AE2A20910DAF24A ON raiting (actor_id)');
        $this->addSql('CREATE INDEX IDX_3AE2A2094584665A ON raiting (product_id)');
        $this->addSql('COMMENT ON COLUMN raiting.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN raiting.actor_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN raiting.product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE75954584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE raiting ADD CONSTRAINT FK_3AE2A20910DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE raiting ADD CONSTRAINT FK_3AE2A2094584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE material DROP CONSTRAINT FK_7CBE75954584665A');
        $this->addSql('ALTER TABLE raiting DROP CONSTRAINT FK_3AE2A20910DAF24A');
        $this->addSql('ALTER TABLE raiting DROP CONSTRAINT FK_3AE2A2094584665A');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE raiting');
    }
}
