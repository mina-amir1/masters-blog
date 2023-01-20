<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228134446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts_posts (posts_source INT NOT NULL, posts_target INT NOT NULL, INDEX IDX_3A5AE1EB358858DA (posts_source), INDEX IDX_3A5AE1EB2C6D0855 (posts_target), PRIMARY KEY(posts_source, posts_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE posts_posts ADD CONSTRAINT FK_3A5AE1EB358858DA FOREIGN KEY (posts_source) REFERENCES posts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_posts ADD CONSTRAINT FK_3A5AE1EB2C6D0855 FOREIGN KEY (posts_target) REFERENCES posts (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts_posts DROP FOREIGN KEY FK_3A5AE1EB358858DA');
        $this->addSql('ALTER TABLE posts_posts DROP FOREIGN KEY FK_3A5AE1EB2C6D0855');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE posts_posts');
    }
}
