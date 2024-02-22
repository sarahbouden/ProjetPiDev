<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240221143930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, nom_act VARCHAR(255) NOT NULL, type_act VARCHAR(255) NOT NULL, location_act VARCHAR(255) NOT NULL, description_act VARCHAR(255) NOT NULL, photo_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_activite (challenge_id INT NOT NULL, activite_id INT NOT NULL, INDEX IDX_254BB2F598A21AC6 (challenge_id), INDEX IDX_254BB2F59B0F88B1 (activite_id), PRIMARY KEY(challenge_id, activite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenge_activite ADD CONSTRAINT FK_254BB2F598A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_activite ADD CONSTRAINT FK_254BB2F59B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_activité DROP FOREIGN KEY FK_48A7A28F98A21AC6');
        $this->addSql('ALTER TABLE challenge_activité DROP FOREIGN KEY FK_48A7A28FED02027C');
        $this->addSql('DROP TABLE activité');
        $this->addSql('DROP TABLE challenge_activité');
        $this->addSql('ALTER TABLE offre ADD photo_url VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE reservation_id reservation_id INT DEFAULT NULL, CHANGE role role VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activité (id INT AUTO_INCREMENT NOT NULL, nom_act VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type_act VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, location_act VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description_act VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo_url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE challenge_activité (challenge_id INT NOT NULL, activité_id INT NOT NULL, INDEX IDX_48A7A28F98A21AC6 (challenge_id), INDEX IDX_48A7A28FED02027C (activité_id), PRIMARY KEY(challenge_id, activité_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE challenge_activité ADD CONSTRAINT FK_48A7A28F98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_activité ADD CONSTRAINT FK_48A7A28FED02027C FOREIGN KEY (activité_id) REFERENCES activité (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_activite DROP FOREIGN KEY FK_254BB2F598A21AC6');
        $this->addSql('ALTER TABLE challenge_activite DROP FOREIGN KEY FK_254BB2F59B0F88B1');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE challenge_activite');
        $this->addSql('ALTER TABLE offre DROP photo_url');
        $this->addSql('ALTER TABLE user CHANGE reservation_id reservation_id INT NOT NULL, CHANGE role role LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }
}
