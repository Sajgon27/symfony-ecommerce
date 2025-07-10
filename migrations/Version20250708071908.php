<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250708071908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` ADD phone VARCHAR(20) NOT NULL, ADD nip VARCHAR(20) NOT NULL, ADD email VARCHAR(20) NOT NULL, ADD invoice TINYINT(1) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_addres ADD company_name VARCHAR(150) NOT NULL, DROP phone
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` DROP phone, DROP nip, DROP email, DROP invoice
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_addres ADD phone VARCHAR(20) NOT NULL, DROP company_name
        SQL);
    }
}
