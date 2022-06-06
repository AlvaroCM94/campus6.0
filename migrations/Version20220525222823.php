<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220525222823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE usuario_curso (id INT AUTO_INCREMENT NOT NULL, id_usuario_id INT NOT NULL, id_curso_id INT NOT NULL, estado VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D7E52AF27EB2C349 (id_usuario_id), UNIQUE INDEX UNIQ_D7E52AF2D710A68A (id_curso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE usuario_curso ADD CONSTRAINT FK_D7E52AF27EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE usuario_curso ADD CONSTRAINT FK_D7E52AF2D710A68A FOREIGN KEY (id_curso_id) REFERENCES curso (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE usuario_curso');
    }
}
