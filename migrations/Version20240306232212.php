<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306232212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite_user (activite_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FA43CF3B9B0F88B1 (activite_id), INDEX IDX_FA43CF3BA76ED395 (user_id), PRIMARY KEY(activite_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, author_id INT DEFAULT NULL, activites_id INT DEFAULT NULL, INDEX IDX_9474526CF675F31B (author_id), INDEX IDX_9474526C5B8C31B7 (activites_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE activite_user ADD CONSTRAINT FK_FA43CF3B9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activite_user ADD CONSTRAINT FK_FA43CF3BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5B8C31B7 FOREIGN KEY (activites_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE activite ADD image_name VARCHAR(255) DEFAULT NULL, ADD users_id INT DEFAULT NULL, DROP photo_url');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B875551567B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B875551567B3B43D ON activite (users_id)');
        $this->addSql('ALTER TABLE hotel ADD price DOUBLE PRECISION NOT NULL, CHANGE description description VARCHAR(9000) NOT NULL');
        $this->addSql('ALTER TABLE offre ADD photo_url VARCHAR(255) NOT NULL, ADD prix DOUBLE PRECISION NOT NULL, ADD created_at DATE NOT NULL');
        $this->addSql('ALTER TABLE partenaire ADD address VARCHAR(255) NOT NULL, ADD photo_url VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite_user DROP FOREIGN KEY FK_FA43CF3B9B0F88B1');
        $this->addSql('ALTER TABLE activite_user DROP FOREIGN KEY FK_FA43CF3BA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5B8C31B7');
        $this->addSql('DROP TABLE activite_user');
        $this->addSql('DROP TABLE comment');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B875551567B3B43D');
        $this->addSql('DROP INDEX IDX_B875551567B3B43D ON activite');
        $this->addSql('ALTER TABLE activite ADD photo_url VARCHAR(255) NOT NULL, DROP image_name, DROP users_id');
        $this->addSql('ALTER TABLE hotel DROP price, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE offre DROP photo_url, DROP prix, DROP created_at');
        $this->addSql('ALTER TABLE partenaire DROP address, DROP photo_url');
    }
}
