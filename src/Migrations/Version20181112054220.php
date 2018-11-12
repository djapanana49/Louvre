<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181112054220 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE billets (id INT AUTO_INCREMENT NOT NULL, tarif_id INT NOT NULL, reservation_id INT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, date_de_naissance DATETIME NOT NULL, INDEX IDX_4FCF9B68357C0A59 (tarif_id), INDEX IDX_4FCF9B68B83297E7 (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, num_reservation VARCHAR(255) NOT NULL, date_visite DATETIME NOT NULL, date_reservation DATETIME NOT NULL, nb_billets INT NOT NULL, mail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billets ADD CONSTRAINT FK_4FCF9B68357C0A59 FOREIGN KEY (tarif_id) REFERENCES tarifs (id)');
        $this->addSql('ALTER TABLE billets ADD CONSTRAINT FK_4FCF9B68B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservations (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billets DROP FOREIGN KEY FK_4FCF9B68B83297E7');
        $this->addSql('DROP TABLE billets');
        $this->addSql('DROP TABLE reservations');
    }
}
