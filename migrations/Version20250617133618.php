<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250617133618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item ADD order_item_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09E415FB15 FOREIGN KEY (order_item_id) REFERENCES `order` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_52EA1F09E415FB15 ON order_item (order_item_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09E415FB15
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_52EA1F09E415FB15 ON order_item
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item DROP order_item_id
        SQL);
    }
}
