<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220319164218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workout_user (workout_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(workout_id, user_id))');
        $this->addSql('CREATE INDEX IDX_F51DD535A6CCCFC9 ON workout_user (workout_id)');
        $this->addSql('CREATE INDEX IDX_F51DD535A76ED395 ON workout_user (user_id)');
        $this->addSql('ALTER TABLE workout_user ADD CONSTRAINT FK_F51DD535A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE workout_user ADD CONSTRAINT FK_F51DD535A76ED395 FOREIGN KEY (user_id) REFERENCES "user_table" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE workout ADD plan JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE workout_user');
        $this->addSql('ALTER TABLE workout DROP plan');
    }
}
