<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220129195201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, status VARCHAR(30) NOT NULL, booked_from DATE NOT NULL, booked_until DATE NOT NULL, INDEX IDX_E00CEDDEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_listing (booking_id INT NOT NULL, listing_id INT NOT NULL, INDEX IDX_91BE0DF43301C60 (booking_id), INDEX IDX_91BE0DF4D4619D1A (listing_id), PRIMARY KEY(booking_id, listing_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, listing_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price INT NOT NULL, beds INT NOT NULL, guests INT NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, published DATETIME NOT NULL, INDEX IDX_CB0048D4A76ED395 (user_id), INDEX IDX_CB0048D4455844B0 (listing_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing_availability (id INT AUTO_INCREMENT NOT NULL, listing_id INT DEFAULT NULL, available_from DATE NOT NULL, available_until DATE NOT NULL, INDEX IDX_BA858CBED4619D1A (listing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking_listing ADD CONSTRAINT FK_91BE0DF43301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_listing ADD CONSTRAINT FK_91BE0DF4D4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE listing ADD CONSTRAINT FK_CB0048D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE listing ADD CONSTRAINT FK_CB0048D4455844B0 FOREIGN KEY (listing_category_id) REFERENCES listing_category (id)');
        $this->addSql('ALTER TABLE listing_availability ADD CONSTRAINT FK_BA858CBED4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id)');
        $this->addSql('ALTER TABLE listing_amenity ADD checked TINYINT(1) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE listing_amenity ADD CONSTRAINT FK_B45E022CD4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id)');
        $this->addSql('ALTER TABLE listing_picture ADD CONSTRAINT FK_9E534C6D4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926221BC7E6B6 FOREIGN KEY (writer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622D4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_listing DROP FOREIGN KEY FK_91BE0DF43301C60');
        $this->addSql('ALTER TABLE booking_listing DROP FOREIGN KEY FK_91BE0DF4D4619D1A');
        $this->addSql('ALTER TABLE listing_amenity DROP FOREIGN KEY FK_B45E022CD4619D1A');
        $this->addSql('ALTER TABLE listing_availability DROP FOREIGN KEY FK_BA858CBED4619D1A');
        $this->addSql('ALTER TABLE listing_picture DROP FOREIGN KEY FK_9E534C6D4619D1A');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622D4619D1A');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE listing DROP FOREIGN KEY FK_CB0048D4A76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926221BC7E6B6');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_listing');
        $this->addSql('DROP TABLE listing');
        $this->addSql('DROP TABLE listing_availability');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE listing_amenity DROP checked, CHANGE name name TINYINT(1) NOT NULL');
    }
}
