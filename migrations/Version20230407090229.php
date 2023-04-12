<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407090229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_produits (user_id INT NOT NULL, produits_id INT NOT NULL, INDEX IDX_5EA03B8CA76ED395 (user_id), INDEX IDX_5EA03B8CCD11A2CF (produits_id), PRIMARY KEY(user_id, produits_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_produits ADD CONSTRAINT FK_5EA03B8CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_produits ADD CONSTRAINT FK_5EA03B8CCD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produits ADD image VARCHAR(200) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_produits DROP FOREIGN KEY FK_5EA03B8CA76ED395');
        $this->addSql('ALTER TABLE user_produits DROP FOREIGN KEY FK_5EA03B8CCD11A2CF');
        $this->addSql('DROP TABLE user_produits');
        $this->addSql('ALTER TABLE produits DROP image');
    }
}
