<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130002248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file ADD candidate_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F361091BD8781 FOREIGN KEY (candidate_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8C9F361091BD8781 ON file (candidate_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F361091BD8781');
        $this->addSql('DROP INDEX UNIQ_8C9F361091BD8781 ON file');
        $this->addSql('ALTER TABLE file DROP candidate_id');
    }
}
