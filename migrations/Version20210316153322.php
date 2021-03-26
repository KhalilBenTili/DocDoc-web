<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316153322 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fourniseur_service DROP FOREIGN KEY FK_B29BB859BCF5E72D');
        $this->addSql('DROP INDEX IDX_B29BB859BCF5E72D ON fourniseur_service');
        $this->addSql('ALTER TABLE fourniseur_service DROP categorie_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fourniseur_service ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE fourniseur_service ADD CONSTRAINT FK_B29BB859BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_service (id)');
        $this->addSql('CREATE INDEX IDX_B29BB859BCF5E72D ON fourniseur_service (categorie_id)');
    }
}
