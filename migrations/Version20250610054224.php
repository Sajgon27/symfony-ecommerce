<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250610054224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE product_category (id INT AUTO_INCREMENT NOT NULL, product_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description LONGTEXT DEFAULT NULL, INDEX IDX_CDFC7356BE6903FD (product_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_category ADD CONSTRAINT FK_CDFC7356BE6903FD FOREIGN KEY (product_category_id) REFERENCES product_category (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC7356BE6903FD
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product_category
        SQL);
    }
}
