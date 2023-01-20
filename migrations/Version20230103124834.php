<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230103124834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abstract_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account (id INT NOT NULL, phone VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_account (id INT NOT NULL, admin_role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, account_id INT NOT NULL, comment_text VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_9474526C4B89032C (post_id), INDEX IDX_9474526C9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE followers (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, followed_by_id INT NOT NULL, followed_since DATE NOT NULL, INDEX IDX_8408FDA79B6B5FBA (account_id), INDEX IDX_8408FDA73970CDB6 (followed_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, account_id INT NOT NULL, post_id INT DEFAULT NULL, is_seen TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_BF5476CA7E3C61F9 (owner_id), INDEX IDX_BF5476CA9B6B5FBA (account_id), INDEX IDX_BF5476CA4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, text VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, likes INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5A8A6C8D9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4BF396750 FOREIGN KEY (id) REFERENCES abstract_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin_account ADD CONSTRAINT FK_B90AD42DBF396750 FOREIGN KEY (id) REFERENCES abstract_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE followers ADD CONSTRAINT FK_8408FDA79B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE followers ADD CONSTRAINT FK_8408FDA73970CDB6 FOREIGN KEY (followed_by_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA7E3C61F9 FOREIGN KEY (owner_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE posts_posts DROP FOREIGN KEY FK_3A5AE1EB2C6D0855');
        $this->addSql('ALTER TABLE posts_posts DROP FOREIGN KEY FK_3A5AE1EB358858DA');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE posts_posts');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE posts_posts (posts_source INT NOT NULL, posts_target INT NOT NULL, INDEX IDX_3A5AE1EB358858DA (posts_source), INDEX IDX_3A5AE1EB2C6D0855 (posts_target), PRIMARY KEY(posts_source, posts_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE posts_posts ADD CONSTRAINT FK_3A5AE1EB2C6D0855 FOREIGN KEY (posts_target) REFERENCES posts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_posts ADD CONSTRAINT FK_3A5AE1EB358858DA FOREIGN KEY (posts_source) REFERENCES posts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A4BF396750');
        $this->addSql('ALTER TABLE admin_account DROP FOREIGN KEY FK_B90AD42DBF396750');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4B89032C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9B6B5FBA');
        $this->addSql('ALTER TABLE followers DROP FOREIGN KEY FK_8408FDA79B6B5FBA');
        $this->addSql('ALTER TABLE followers DROP FOREIGN KEY FK_8408FDA73970CDB6');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA7E3C61F9');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA9B6B5FBA');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA4B89032C');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D9B6B5FBA');
        $this->addSql('DROP TABLE abstract_user');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE admin_account');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE followers');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE post');
    }
}
