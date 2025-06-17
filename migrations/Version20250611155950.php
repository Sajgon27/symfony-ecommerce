<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611155950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, order_id_id INT NOT NULL, product_id_id INT NOT NULL, product_name VARCHAR(255) NOT NULL, product_sku VARCHAR(40) DEFAULT NULL, quantity INT NOT NULL, unit_price INT NOT NULL, INDEX IDX_52EA1F09FCDAEAAA (order_id_id), INDEX IDX_52EA1F09DE18E50B (product_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09FCDAEAAA
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09DE18E50B
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE order_item
        SQL);
    }
}
