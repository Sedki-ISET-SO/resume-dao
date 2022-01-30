<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220129222723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resume (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE education ADD resume_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED2D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
        $this->addSql('CREATE INDEX IDX_DB0A5ED2D262AF09 ON education (resume_id)');
        $this->addSql('ALTER TABLE skill ADD resume_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE477D262AF09 ON skill (resume_id)');
        $this->addSql('ALTER TABLE user ADD resume_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D262AF09 ON user (resume_id)');
        $this->addSql('ALTER TABLE work_experience ADD resume_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE work_experience ADD CONSTRAINT FK_1EF36CD0D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
        $this->addSql('CREATE INDEX IDX_1EF36CD0D262AF09 ON work_experience (resume_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE education DROP FOREIGN KEY FK_DB0A5ED2D262AF09');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477D262AF09');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D262AF09');
        $this->addSql('ALTER TABLE work_experience DROP FOREIGN KEY FK_1EF36CD0D262AF09');
        $this->addSql('DROP TABLE resume');
        $this->addSql('DROP INDEX IDX_DB0A5ED2D262AF09 ON education');
        $this->addSql('ALTER TABLE education DROP resume_id');
        $this->addSql('DROP INDEX IDX_5E3DE477D262AF09 ON skill');
        $this->addSql('ALTER TABLE skill DROP resume_id');
        $this->addSql('DROP INDEX UNIQ_8D93D649D262AF09 ON user');
        $this->addSql('ALTER TABLE user DROP resume_id');
        $this->addSql('DROP INDEX IDX_1EF36CD0D262AF09 ON work_experience');
        $this->addSql('ALTER TABLE work_experience DROP resume_id');
    }
}
