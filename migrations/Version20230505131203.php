<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505131203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie ADD categorie VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE scategorie ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE scategorie ADD CONSTRAINT FK_51809477BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_51809477BCF5E72D ON scategorie (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP categorie');
        $this->addSql('ALTER TABLE scategorie DROP FOREIGN KEY FK_51809477BCF5E72D');
        $this->addSql('DROP INDEX IDX_51809477BCF5E72D ON scategorie');
        $this->addSql('ALTER TABLE scategorie DROP categorie_id');
    }
}
