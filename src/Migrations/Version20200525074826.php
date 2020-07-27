<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200525074826 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE season_program');
        $this->addSql('ALTER TABLE season ADD program_id INT NOT NULL, CHANGE year year INT DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA93EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('CREATE INDEX IDX_F0E45BA93EB8070A ON season (program_id)');
        $this->addSql('ALTER TABLE episode ADD poster VARCHAR(255) DEFAULT NULL, CHANGE title title VARCHAR(255) NOT NULL, CHANGE number number INT DEFAULT NULL, CHANGE synopsis synopsis LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE season_program (season_id INT NOT NULL, program_id INT NOT NULL, INDEX IDX_B794DEDA3EB8070A (program_id), INDEX IDX_B794DEDA4EC001D1 (season_id), PRIMARY KEY(season_id, program_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE season_program ADD CONSTRAINT FK_B794DEDA3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE season_program ADD CONSTRAINT FK_B794DEDA4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE episode DROP poster, CHANGE title title VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE number number INT NOT NULL, CHANGE synopsis synopsis LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY FK_F0E45BA93EB8070A');
        $this->addSql('DROP INDEX IDX_F0E45BA93EB8070A ON season');
        $this->addSql('ALTER TABLE season DROP program_id, CHANGE year year INT NOT NULL, CHANGE description description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
