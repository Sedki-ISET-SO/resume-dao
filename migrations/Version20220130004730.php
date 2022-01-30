<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130004730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE listing_picture DROP FOREIGN KEY FK_9E534C6D4619D1A');
        $this->addSql('DROP INDEX IDX_9E534C6D4619D1A ON listing_picture');
        $this->addSql('ALTER TABLE listing_picture DROP listing_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE listing_picture ADD listing_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE listing_picture ADD CONSTRAINT FK_9E534C6D4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9E534C6D4619D1A ON listing_picture (listing_id)');
    }
}
