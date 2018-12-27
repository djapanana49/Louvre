<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181227163724 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billets DROP FOREIGN KEY FK_4FCF9B68357C0A59');
        $this->addSql('DROP INDEX IDX_4FCF9B68357C0A59 ON billets');
        $this->addSql('ALTER TABLE billets ADD reduit TINYINT(1) NOT NULL, CHANGE tarif_id tarif INT NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD journee TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billets DROP reduit, CHANGE tarif tarif_id INT NOT NULL');
        $this->addSql('ALTER TABLE billets ADD CONSTRAINT FK_4FCF9B68357C0A59 FOREIGN KEY (tarif_id) REFERENCES tarifs (id)');
        $this->addSql('CREATE INDEX IDX_4FCF9B68357C0A59 ON billets (tarif_id)');
        $this->addSql('ALTER TABLE reservations DROP journee');
    }
}
