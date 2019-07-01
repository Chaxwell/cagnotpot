<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190630035202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaign CHANGE author author VARCHAR(150) DEFAULT \'NULL\', CHANGE email email VARCHAR(150) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE payment ADD hide_identity TINYINT(1) DEFAULT \'0\', ADD hide_amount TINYINT(1) DEFAULT \'0\', ADD card_name VARCHAR(255) DEFAULT NULL, ADD card_number BIGINT DEFAULT NULL, ADD card_expiration_date DATETIME DEFAULT NULL, ADD card_cvv INT DEFAULT NULL, CHANGE participant_id participant_id INT DEFAULT NULL, CHANGE amount amount INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE participant CHANGE campaign_id campaign_id VARCHAR(32) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaign CHANGE author author VARCHAR(150) DEFAULT \'NULL\' COLLATE utf8_general_ci, CHANGE email email VARCHAR(150) DEFAULT \'NULL\' COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE participant CHANGE campaign_id campaign_id VARCHAR(32) DEFAULT \'NULL\' COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE payment DROP hide_identity, DROP hide_amount, DROP card_name, DROP card_number, DROP card_expiration_date, DROP card_cvv, CHANGE participant_id participant_id INT DEFAULT NULL, CHANGE amount amount INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
    }
}
