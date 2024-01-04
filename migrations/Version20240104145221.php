<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240104145221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factures ADD clients_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590BAB014612 FOREIGN KEY (clients_id) REFERENCES clients (id)');
        $this->addSql('CREATE INDEX IDX_647590BAB014612 ON factures (clients_id)');
        $this->addSql('ALTER TABLE factures_details ADD factures_id INT DEFAULT NULL, ADD prestations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE factures_details ADD CONSTRAINT FK_705495B1E9D518F9 FOREIGN KEY (factures_id) REFERENCES factures (id)');
        $this->addSql('ALTER TABLE factures_details ADD CONSTRAINT FK_705495B18BE96D0D FOREIGN KEY (prestations_id) REFERENCES prestations (id)');
        $this->addSql('CREATE INDEX IDX_705495B1E9D518F9 ON factures_details (factures_id)');
        $this->addSql('CREATE INDEX IDX_705495B18BE96D0D ON factures_details (prestations_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factures_details DROP FOREIGN KEY FK_705495B1E9D518F9');
        $this->addSql('ALTER TABLE factures_details DROP FOREIGN KEY FK_705495B18BE96D0D');
        $this->addSql('DROP INDEX IDX_705495B1E9D518F9 ON factures_details');
        $this->addSql('DROP INDEX IDX_705495B18BE96D0D ON factures_details');
        $this->addSql('ALTER TABLE factures_details DROP factures_id, DROP prestations_id');
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590BAB014612');
        $this->addSql('DROP INDEX IDX_647590BAB014612 ON factures');
        $this->addSql('ALTER TABLE factures DROP clients_id');
    }
}
