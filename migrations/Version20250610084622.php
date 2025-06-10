<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250610084622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC7356BE6903FD
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_CDFC7356BE6903FD ON product_category
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_category CHANGE product_category_id parent_category_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_category ADD CONSTRAINT FK_CDFC7356796A8F92 FOREIGN KEY (parent_category_id) REFERENCES product_category (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CDFC7356796A8F92 ON product_category (parent_category_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC7356796A8F92
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_CDFC7356796A8F92 ON product_category
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_category CHANGE parent_category_id product_category_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_category ADD CONSTRAINT FK_CDFC7356BE6903FD FOREIGN KEY (product_category_id) REFERENCES product_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CDFC7356BE6903FD ON product_category (product_category_id)
        SQL);
    }
}
