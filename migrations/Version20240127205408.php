<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240127205408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE banks (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currencies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currency_exchanges (id INT AUTO_INCREMENT NOT NULL, currency_id INT DEFAULT NULL, bank_id INT DEFAULT NULL, updated_at DATETIME NOT NULL, sell_rate NUMERIC(8, 4) NOT NULL, buy_rate NUMERIC(8, 4) NOT NULL, INDEX IDX_B68A14AB38248176 (currency_id), INDEX IDX_B68A14AB11C8FB41 (bank_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE currency_exchanges ADD CONSTRAINT FK_B68A14AB38248176 FOREIGN KEY (currency_id) REFERENCES currencies (id)');
        $this->addSql('ALTER TABLE currency_exchanges ADD CONSTRAINT FK_B68A14AB11C8FB41 FOREIGN KEY (bank_id) REFERENCES banks (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE currency_exchanges DROP FOREIGN KEY FK_B68A14AB38248176');
        $this->addSql('ALTER TABLE currency_exchanges DROP FOREIGN KEY FK_B68A14AB11C8FB41');
        $this->addSql('DROP TABLE banks');
        $this->addSql('DROP TABLE currencies');
        $this->addSql('DROP TABLE currency_exchanges');
    }
}
