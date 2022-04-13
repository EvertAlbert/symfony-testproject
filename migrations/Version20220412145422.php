<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220412145422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add membershipRequest';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE membership_request ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD removed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE membership_request DROP created_at, DROP updated_at, DROP removed_at');
    }
}
