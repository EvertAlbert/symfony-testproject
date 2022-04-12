<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220408140019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created PhotoAlbum entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE photo_album (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, file_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE photo_album');
    }
}
