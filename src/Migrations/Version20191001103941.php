<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191001103941 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY rent_ibfk_1');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY rent_ibfk_2');
        $this->addSql('DROP INDEX id_user ON rent');
        $this->addSql('DROP INDEX id_vehicle ON rent');
        $this->addSql('ALTER TABLE rent CHANGE id_user id_user INT DEFAULT NULL, CHANGE id_vehicle id_vehicle INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY vehicle_ibfk_1');
        $this->addSql('DROP INDEX id_category ON vehicle');
        $this->addSql('ALTER TABLE vehicle CHANGE available available TINYINT(1) DEFAULT NULL, CHANGE booking_price daily_price INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rent CHANGE id_user id_user INT DEFAULT NULL, CHANGE id_vehicle id_vehicle INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT rent_ibfk_1 FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT rent_ibfk_2 FOREIGN KEY (id_vehicle) REFERENCES vehicle (id)');
        $this->addSql('CREATE INDEX id_user ON rent (id_user)');
        $this->addSql('CREATE INDEX id_vehicle ON rent (id_vehicle)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
        $this->addSql('ALTER TABLE vehicle CHANGE available available TINYINT(1) DEFAULT \'NULL\', CHANGE daily_price booking_price INT NOT NULL');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT vehicle_ibfk_1 FOREIGN KEY (id_category) REFERENCES category (id)');
        $this->addSql('CREATE INDEX id_category ON vehicle (id_category)');
    }
}
