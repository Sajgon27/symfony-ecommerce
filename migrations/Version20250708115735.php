<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250708115735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE order_addres ADD name VARCHAR(100) NOT NULL, ADD surname VARCHAR(100) NOT NULL, DROP first_name, DROP last_name, CHANGE address_line_1 address_line1 VARCHAR(255) NOT NULL, CHANGE address_line_2 address_line2 VARCHAR(255) DEFAULT NULL, CHANGE company_name company VARCHAR(150) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE order_addres ADD first_name VARCHAR(100) NOT NULL, ADD last_name VARCHAR(100) NOT NULL, DROP name, DROP surname, CHANGE address_line1 address_line_1 VARCHAR(255) NOT NULL, CHANGE address_line2 address_line_2 VARCHAR(255) DEFAULT NULL, CHANGE company company_name VARCHAR(150) NOT NULL
        SQL);
    }
}
