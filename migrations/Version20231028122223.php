<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231028122223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql('CREATE TABLE weather_data (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, date DATE NOT NULL, celsius NUMERIC(3, 0) NOT NULL, wind_speed NUMERIC(10, 2) NOT NULL, humidity INTEGER NOT NULL, CONSTRAINT FK_3370691A8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
//        $this->addSql('CREATE INDEX IDX_3370691A8BAC62AF ON weather_data (city_id)');
        $this->addSql('ALTER TABLE city ADD COLUMN country_code VARCHAR(2)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql('DROP TABLE weather_data');
        $this->addSql('ALTER TABLE city DROP COLUMN country_code');
    }
}
