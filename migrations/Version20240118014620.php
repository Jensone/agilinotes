<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118014620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE following_follower DROP FOREIGN KEY FK_4AD0802E1816E3A3');
        $this->addSql('DROP TABLE following');
        $this->addSql('ALTER TABLE following_follower DROP FOREIGN KEY FK_4AD0802EA76ED395');
        $this->addSql('DROP INDEX IDX_4AD0802E1816E3A3 ON following_follower');
        $this->addSql('DROP INDEX IDX_4AD0802EA76ED395 ON following_follower');
        $this->addSql('DROP INDEX `primary` ON following_follower');
        $this->addSql('ALTER TABLE following_follower ADD user_source INT NOT NULL, ADD user_target INT NOT NULL, DROP following_id, DROP user_id');
        $this->addSql('ALTER TABLE following_follower ADD CONSTRAINT FK_4AD0802E3AD8644E FOREIGN KEY (user_source) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE following_follower ADD CONSTRAINT FK_4AD0802E233D34C1 FOREIGN KEY (user_target) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4AD0802E3AD8644E ON following_follower (user_source)');
        $this->addSql('CREATE INDEX IDX_4AD0802E233D34C1 ON following_follower (user_target)');
        $this->addSql('ALTER TABLE following_follower ADD PRIMARY KEY (user_source, user_target)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE following (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE following_follower DROP FOREIGN KEY FK_4AD0802E3AD8644E');
        $this->addSql('ALTER TABLE following_follower DROP FOREIGN KEY FK_4AD0802E233D34C1');
        $this->addSql('DROP INDEX IDX_4AD0802E3AD8644E ON following_follower');
        $this->addSql('DROP INDEX IDX_4AD0802E233D34C1 ON following_follower');
        $this->addSql('DROP INDEX `PRIMARY` ON following_follower');
        $this->addSql('ALTER TABLE following_follower ADD following_id INT NOT NULL, ADD user_id INT NOT NULL, DROP user_source, DROP user_target');
        $this->addSql('ALTER TABLE following_follower ADD CONSTRAINT FK_4AD0802E1816E3A3 FOREIGN KEY (following_id) REFERENCES following (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE following_follower ADD CONSTRAINT FK_4AD0802EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4AD0802E1816E3A3 ON following_follower (following_id)');
        $this->addSql('CREATE INDEX IDX_4AD0802EA76ED395 ON following_follower (user_id)');
        $this->addSql('ALTER TABLE following_follower ADD PRIMARY KEY (following_id, user_id)');
    }
}
