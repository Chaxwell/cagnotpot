<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190628232005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaign ADD email VARCHAR(150) DEFAULT \'NULL\', CHANGE author author VARCHAR(150) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE payment CHANGE participant_id participant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participant CHANGE campaign_id campaign_id VARCHAR(32) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaign DROP email, CHANGE author author VARCHAR(150) DEFAULT \'\'NULL\'\' COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE participant CHANGE campaign_id campaign_id VARCHAR(32) DEFAULT \'NULL\' COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE payment CHANGE participant_id participant_id INT DEFAULT NULL');
    }
}
