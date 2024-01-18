<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118013852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE following_follower (following_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4AD0802E1816E3A3 (following_id), INDEX IDX_4AD0802EA76ED395 (user_id), PRIMARY KEY(following_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE following_follower ADD CONSTRAINT FK_4AD0802E1816E3A3 FOREIGN KEY (following_id) REFERENCES following (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE following_follower ADD CONSTRAINT FK_4AD0802EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE following_user DROP FOREIGN KEY FK_58D784211816E3A3');
        $this->addSql('ALTER TABLE following_user DROP FOREIGN KEY FK_58D78421A76ED395');
        $this->addSql('DROP TABLE following_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE following_user (following_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_58D784211816E3A3 (following_id), INDEX IDX_58D78421A76ED395 (user_id), PRIMARY KEY(following_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE following_user ADD CONSTRAINT FK_58D784211816E3A3 FOREIGN KEY (following_id) REFERENCES following (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE following_user ADD CONSTRAINT FK_58D78421A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE following_follower DROP FOREIGN KEY FK_4AD0802E1816E3A3');
        $this->addSql('ALTER TABLE following_follower DROP FOREIGN KEY FK_4AD0802EA76ED395');
        $this->addSql('DROP TABLE following_follower');
    }
}
