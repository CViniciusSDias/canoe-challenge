<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231201025749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fund (id UUID NOT NULL, manager_id UUID NOT NULL, name VARCHAR(255) NOT NULL, start_year SMALLINT NOT NULL, aliases JSONB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DC923E10783E3463 ON fund (manager_id)');
        $this->addSql('COMMENT ON COLUMN fund.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN fund.manager_id IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE fund_manager (id UUID NOT NULL, company_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN fund_manager.id IS \'(DC2Type:ulid)\'');
        $this->addSql('ALTER TABLE fund ADD CONSTRAINT FK_DC923E10783E3463 FOREIGN KEY (manager_id) REFERENCES fund_manager (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE fund DROP CONSTRAINT FK_DC923E10783E3463');
        $this->addSql('DROP TABLE fund');
        $this->addSql('DROP TABLE fund_manager');
    }
}
