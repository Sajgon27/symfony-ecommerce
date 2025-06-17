<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611161039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE order_addres (id INT AUTO_INCREMENT NOT NULL, order_id_id INT NOT NULL, type VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, address_line_1 VARCHAR(255) NOT NULL, address_line_2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(10) NOT NULL, phone VARCHAR(20) NOT NULL, INDEX IDX_EFE0DF0AFCDAEAAA (order_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_addres ADD CONSTRAINT FK_EFE0DF0AFCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE order_addres DROP FOREIGN KEY FK_EFE0DF0AFCDAEAAA
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE order_addres
        SQL);
    }
}
