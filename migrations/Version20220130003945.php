<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130003945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pdf (id INT AUTO_INCREMENT NOT NULL, candidate_id INT DEFAULT NULL, INDEX IDX_EF0DB8C91BD8781 (candidate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pdf ADD CONSTRAINT FK_EF0DB8C91BD8781 FOREIGN KEY (candidate_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE file');
        $this->addSql('ALTER TABLE listing_picture ADD p_df_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE listing_picture ADD CONSTRAINT FK_9E534C66723D007 FOREIGN KEY (p_df_id) REFERENCES pdf (id)');
        $this->addSql('CREATE INDEX IDX_9E534C66723D007 ON listing_picture (p_df_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE listing_picture DROP FOREIGN KEY FK_9E534C66723D007');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, candidate_id INT DEFAULT NULL, INDEX IDX_8C9F361091BD8781 (candidate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F361091BD8781 FOREIGN KEY (candidate_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE pdf');
        $this->addSql('DROP INDEX IDX_9E534C66723D007 ON listing_picture');
        $this->addSql('ALTER TABLE listing_picture DROP p_df_id');
    }
}
