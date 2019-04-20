<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190418153911 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, sex CHAR(1) NOT NULL, phone_number VARCHAR(16) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE doctor ADD user_id INT DEFAULT NULL, DROP first_name, DROP last_name, DROP sex, DROP phone_number, DROP password');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1FC0F36AA76ED395 ON doctor (user_id)');
        $this->addSql('ALTER TABLE patient ADD user_id INT DEFAULT NULL, DROP first_name, DROP last_name, DROP sex, DROP phone_number, DROP password, CHANGE date_of_birth date_of_birth DATE NOT NULL');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EBA76ED395 ON patient (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36AA76ED395');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBA76ED395');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX UNIQ_1FC0F36AA76ED395 ON doctor');
        $this->addSql('ALTER TABLE doctor ADD first_name VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, ADD last_name VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, ADD sex CHAR(1) NOT NULL COLLATE utf8_unicode_ci, ADD phone_number VARCHAR(16) NOT NULL COLLATE utf8_unicode_ci, ADD password CHAR(60) NOT NULL COLLATE utf8_unicode_ci, DROP user_id');
        $this->addSql('DROP INDEX UNIQ_1ADAD7EBA76ED395 ON patient');
        $this->addSql('ALTER TABLE patient ADD first_name VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, ADD last_name VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, ADD sex CHAR(1) NOT NULL COLLATE utf8_unicode_ci, ADD phone_number VARCHAR(16) NOT NULL COLLATE utf8_unicode_ci, ADD password CHAR(60) NOT NULL COLLATE utf8_unicode_ci, DROP user_id, CHANGE date_of_birth date_of_birth DATETIME NOT NULL');
    }
}
