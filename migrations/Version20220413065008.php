<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220413065008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update membershipRequest with approvedAt value.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE membership_request ADD approved_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE membership_request DROP approved_at');
    }
}
