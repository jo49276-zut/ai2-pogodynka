<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127131445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql('CREATE TEMPORARY TABLE __temp__city AS SELECT id, name, latitude, longitude, country_code FROM city');
//        $this->addSql('DROP TABLE city');
//        $this->addSql('CREATE TABLE city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, latitude NUMERIC(10, 6) NOT NULL, longitude NUMERIC(10, 6) NOT NULL, country_code VARCHAR(2) NOT NULL)');
//        $this->addSql('INSERT INTO city (id, name, latitude, longitude, country_code) SELECT id, name, latitude, longitude, country_code FROM __temp__city');
//        $this->addSql('DROP TABLE __temp__city');
//        $this->addSql('ALTER TABLE city ALTER COLUMN country_code SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql('CREATE TEMPORARY TABLE __temp__city AS SELECT id, name, latitude, longitude, country_code FROM city');
//        $this->addSql('DROP TABLE city');
//        $this->addSql('CREATE TABLE city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, latitude NUMERIC(10, 6) NOT NULL, longitude NUMERIC(10, 6) NOT NULL, country_code VARCHAR(2) DEFAULT NULL)');
//        $this->addSql('INSERT INTO city (id, name, latitude, longitude, country_code) SELECT id, name, latitude, longitude, country_code FROM __temp__city');
//        $this->addSql('DROP TABLE __temp__city');

    }
}
