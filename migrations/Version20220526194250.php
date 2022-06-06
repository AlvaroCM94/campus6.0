<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220526194250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE instructor_usuario (id INT AUTO_INCREMENT NOT NULL, instructor_id INT NOT NULL, alumno_id INT NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_40C7155D8C4FC193 (instructor_id), INDEX IDX_40C7155DFC28E5EE (alumno_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lugares (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, coordenadas VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reserva (id INT AUTO_INCREMENT NOT NULL, id_usuario_id INT NOT NULL, id_curso_id INT NOT NULL, lugar_id INT NOT NULL, fecha DATETIME NOT NULL, INDEX IDX_188D2E3B7EB2C349 (id_usuario_id), INDEX IDX_188D2E3BD710A68A (id_curso_id), INDEX IDX_188D2E3BB5A3803B (lugar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE instructor_usuario ADD CONSTRAINT FK_40C7155D8C4FC193 FOREIGN KEY (instructor_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE instructor_usuario ADD CONSTRAINT FK_40C7155DFC28E5EE FOREIGN KEY (alumno_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B7EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BD710A68A FOREIGN KEY (id_curso_id) REFERENCES curso (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BB5A3803B FOREIGN KEY (lugar_id) REFERENCES lugares (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BB5A3803B');
        $this->addSql('DROP TABLE instructor_usuario');
        $this->addSql('DROP TABLE lugares');
        $this->addSql('DROP TABLE reserva');
    }
}
