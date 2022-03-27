<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220326211552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_group (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_group_user (user_group_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(user_group_id, user_id))');
        $this->addSql('CREATE INDEX IDX_3AE4BD51ED93D47 ON user_group_user (user_group_id)');
        $this->addSql('CREATE INDEX IDX_3AE4BD5A76ED395 ON user_group_user (user_id)');
        $this->addSql('CREATE TABLE user_group_workout (user_group_id INT NOT NULL, workout_id INT NOT NULL, PRIMARY KEY(user_group_id, workout_id))');
        $this->addSql('CREATE INDEX IDX_C11022E1ED93D47 ON user_group_workout (user_group_id)');
        $this->addSql('CREATE INDEX IDX_C11022EA6CCCFC9 ON user_group_workout (workout_id)');
        $this->addSql('ALTER TABLE user_group_user ADD CONSTRAINT FK_3AE4BD51ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_group (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group_user ADD CONSTRAINT FK_3AE4BD5A76ED395 FOREIGN KEY (user_id) REFERENCES "user_table" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group_workout ADD CONSTRAINT FK_C11022E1ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_group (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group_workout ADD CONSTRAINT FK_C11022EA6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category DROP parent');
        $this->addSql('ALTER TABLE category DROP childs');
        $this->addSql('ALTER TABLE workout ADD workout_kind_id INT NOT NULL');
        $this->addSql('ALTER TABLE workout ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB724CA64001 FOREIGN KEY (workout_kind_id) REFERENCES workout_kind (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_649FFB724CA64001 ON workout (workout_kind_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_group_user DROP CONSTRAINT FK_3AE4BD51ED93D47');
        $this->addSql('ALTER TABLE user_group_workout DROP CONSTRAINT FK_C11022E1ED93D47');
        $this->addSql('DROP TABLE user_group');
        $this->addSql('DROP TABLE user_group_user');
        $this->addSql('DROP TABLE user_group_workout');
        $this->addSql('ALTER TABLE category ADD parent VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD childs JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE workout DROP CONSTRAINT FK_649FFB724CA64001');
        $this->addSql('DROP INDEX IDX_649FFB724CA64001');
        $this->addSql('ALTER TABLE workout DROP workout_kind_id');
        $this->addSql('ALTER TABLE workout DROP name');
    }
}
