<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130234608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE education (id INT AUTO_INCREMENT NOT NULL, resume_id INT DEFAULT NULL, degree VARCHAR(255) NOT NULL, university VARCHAR(255) NOT NULL, start VARCHAR(255) NOT NULL, end VARCHAR(255) NOT NULL, INDEX IDX_DB0A5ED2D262AF09 (resume_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing_amenity (id INT AUTO_INCREMENT NOT NULL, listing_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, checked TINYINT(1) NOT NULL, INDEX IDX_B45E022CD4619D1A (listing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing_picture (id INT AUTO_INCREMENT NOT NULL, p_df_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_9E534C66723D007 (p_df_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, INDEX IDX_B6BD307FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pdf (id INT AUTO_INCREMENT NOT NULL, candidate_id INT DEFAULT NULL, INDEX IDX_EF0DB8C91BD8781 (candidate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, writer_id INT NOT NULL, listing_id INT DEFAULT NULL, start_review INT NOT NULL, feedback VARCHAR(255) NOT NULL, INDEX IDX_D88926221BC7E6B6 (writer_id), INDEX IDX_D8892622D4619D1A (listing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resume (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_60C1D0A0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, resume_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5E3DE4775E237E06 (name), INDEX IDX_5E3DE477D262AF09 (resume_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_experience (id INT AUTO_INCREMENT NOT NULL, resume_id INT DEFAULT NULL, role VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, start VARCHAR(255) NOT NULL, end VARCHAR(255) NOT NULL, INDEX IDX_1EF36CD0D262AF09 (resume_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED2D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
        $this->addSql('ALTER TABLE listing_amenity ADD CONSTRAINT FK_B45E022CD4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id)');
        $this->addSql('ALTER TABLE listing_picture ADD CONSTRAINT FK_9E534C66723D007 FOREIGN KEY (p_df_id) REFERENCES pdf (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pdf ADD CONSTRAINT FK_EF0DB8C91BD8781 FOREIGN KEY (candidate_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926221BC7E6B6 FOREIGN KEY (writer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622D4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id)');
        $this->addSql('ALTER TABLE resume ADD CONSTRAINT FK_60C1D0A0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
        $this->addSql('ALTER TABLE work_experience ADD CONSTRAINT FK_1EF36CD0D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
        $this->addSql('DROP INDEX IDX_CB0048D4455844B0 ON listing');
        $this->addSql('ALTER TABLE listing DROP listing_category_id');
        $this->addSql('ALTER TABLE listing_availability ADD CONSTRAINT FK_BA858CBED4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id)');
        $this->addSql('ALTER TABLE user ADD companyname VARCHAR(255) NOT NULL, ADD valid TINYINT(1) NOT NULL, ADD phonenumber VARCHAR(255) NOT NULL, ADD path VARCHAR(255) NOT NULL, ADD secondpath VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE listing_picture DROP FOREIGN KEY FK_9E534C66723D007');
        $this->addSql('ALTER TABLE education DROP FOREIGN KEY FK_DB0A5ED2D262AF09');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477D262AF09');
        $this->addSql('ALTER TABLE work_experience DROP FOREIGN KEY FK_1EF36CD0D262AF09');
        $this->addSql('DROP TABLE education');
        $this->addSql('DROP TABLE listing_amenity');
        $this->addSql('DROP TABLE listing_category');
        $this->addSql('DROP TABLE listing_picture');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE pdf');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE resume');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE work_experience');
        $this->addSql('ALTER TABLE listing ADD listing_category_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_CB0048D4455844B0 ON listing (listing_category_id)');
        $this->addSql('ALTER TABLE listing_availability DROP FOREIGN KEY FK_BA858CBED4619D1A');
        $this->addSql('ALTER TABLE user DROP companyname, DROP valid, DROP phonenumber, DROP path, DROP secondpath');
    }
}
