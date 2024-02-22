<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214121604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activité (id INT AUTO_INCREMENT NOT NULL, nom_act VARCHAR(255) NOT NULL, type_act VARCHAR(255) NOT NULL, location_act VARCHAR(255) NOT NULL, description_act VARCHAR(255) NOT NULL, photo_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge (id INT AUTO_INCREMENT NOT NULL, titre_ch VARCHAR(255) NOT NULL, date_debut_ch DATE NOT NULL, date_fin_ch DATE NOT NULL, objectif_ch VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_user (challenge_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_843CD1CF98A21AC6 (challenge_id), INDEX IDX_843CD1CFA76ED395 (user_id), PRIMARY KEY(challenge_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE challenge_activité (challenge_id INT NOT NULL, activité_id INT NOT NULL, INDEX IDX_48A7A28F98A21AC6 (challenge_id), INDEX IDX_48A7A28FED02027C (activité_id), PRIMARY KEY(challenge_id, activité_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, name_h VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, rating INT NOT NULL, num_h INT NOT NULL, description VARCHAR(255) NOT NULL, photo_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT DEFAULT NULL, nom_offre VARCHAR(255) NOT NULL, description_offre VARCHAR(255) NOT NULL, date_exp DATE NOT NULL, INDEX IDX_AF86866F98DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, nom_p VARCHAR(255) NOT NULL, type_p VARCHAR(255) NOT NULL, description_p VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, url_ressource VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recompense (id INT AUTO_INCREMENT NOT NULL, nom_recp VARCHAR(255) NOT NULL, niveau VARCHAR(255) NOT NULL, description_recp VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_hotel_id INT NOT NULL, date_debut_r DATE NOT NULL, date_fin_r DATE NOT NULL, nbr_perso INT NOT NULL, type_room VARCHAR(255) NOT NULL, id_clent VARCHAR(255) NOT NULL, INDEX IDX_42C849556298578D (id_hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, reservation_id INT NOT NULL, recompense_id INT DEFAULT NULL, cin INT NOT NULL, user_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, num_tel INT NOT NULL, pwd VARCHAR(255) NOT NULL, role LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_8D93D649B83297E7 (reservation_id), INDEX IDX_8D93D6494D714096 (recompense_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenge_user ADD CONSTRAINT FK_843CD1CF98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_user ADD CONSTRAINT FK_843CD1CFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_activité ADD CONSTRAINT FK_48A7A28F98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_activité ADD CONSTRAINT FK_48A7A28FED02027C FOREIGN KEY (activité_id) REFERENCES activité (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849556298578D FOREIGN KEY (id_hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494D714096 FOREIGN KEY (recompense_id) REFERENCES recompense (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge_user DROP FOREIGN KEY FK_843CD1CF98A21AC6');
        $this->addSql('ALTER TABLE challenge_user DROP FOREIGN KEY FK_843CD1CFA76ED395');
        $this->addSql('ALTER TABLE challenge_activité DROP FOREIGN KEY FK_48A7A28F98A21AC6');
        $this->addSql('ALTER TABLE challenge_activité DROP FOREIGN KEY FK_48A7A28FED02027C');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F98DE13AC');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849556298578D');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B83297E7');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494D714096');
        $this->addSql('DROP TABLE activité');
        $this->addSql('DROP TABLE challenge');
        $this->addSql('DROP TABLE challenge_user');
        $this->addSql('DROP TABLE challenge_activité');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE recompense');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
