<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220126082419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE communes_rdv (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calendar ADD communes_rdv_id INT NOT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146FD1A5FF5 FOREIGN KEY (communes_rdv_id) REFERENCES communes_rdv (id)');
        $this->addSql('CREATE INDEX IDX_6EA9A146FD1A5FF5 ON calendar (communes_rdv_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146FD1A5FF5');
        $this->addSql('DROP TABLE communes_rdv');
        $this->addSql('DROP INDEX IDX_6EA9A146FD1A5FF5 ON calendar');
        $this->addSql('ALTER TABLE calendar DROP communes_rdv_id');
    }
}
