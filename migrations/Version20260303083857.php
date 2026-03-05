<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260303083857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignement ADD title VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE assignement ADD teacher VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE assignement ADD due_date DATE NOT NULL');
        $this->addSql('ALTER TABLE course ADD name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE course ADD department VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignement DROP title');
        $this->addSql('ALTER TABLE assignement DROP teacher');
        $this->addSql('ALTER TABLE assignement DROP due_date');
        $this->addSql('ALTER TABLE course DROP name');
        $this->addSql('ALTER TABLE course DROP department');
    }
}
