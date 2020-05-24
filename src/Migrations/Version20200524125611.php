<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200524125611 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, year INT NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season_program (season_id INT NOT NULL, program_id INT NOT NULL, INDEX IDX_B794DEDA4EC001D1 (season_id), INDEX IDX_B794DEDA3EB8070A (program_id), PRIMARY KEY(season_id, program_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(150) NOT NULL, number INT NOT NULL, synopsis LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE season_program ADD CONSTRAINT FK_B794DEDA4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE season_program ADD CONSTRAINT FK_B794DEDA3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program RENAME INDEX is_category TO IDX_92ED778412469DE2');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE season_program DROP FOREIGN KEY FK_B794DEDA4EC001D1');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE season_program');
        $this->addSql('DROP TABLE episode');
        $this->addSql('ALTER TABLE program RENAME INDEX idx_92ed778412469de2 TO is_category');
    }
}
