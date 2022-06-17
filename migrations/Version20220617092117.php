<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220617092117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material CHANGE tipo tipo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE usuario ADD info_inscripcion VARCHAR(255) DEFAULT NULL, DROP apellidos, DROP cp, DROP genero, DROP nivel_estudios, DROP area_titulo, DROP empresa, DROP cargo, DROP alma_mater, DROP areas_interes, DROP telefono, DROP como_conoce, DROP tipo_contacto');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material CHANGE tipo tipo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE usuario ADD cp INT DEFAULT NULL, ADD genero VARCHAR(255) DEFAULT NULL, ADD nivel_estudios VARCHAR(255) DEFAULT NULL, ADD area_titulo VARCHAR(255) DEFAULT NULL, ADD empresa VARCHAR(255) DEFAULT NULL, ADD cargo VARCHAR(255) DEFAULT NULL, ADD alma_mater VARCHAR(255) DEFAULT NULL, ADD areas_interes VARCHAR(255) DEFAULT NULL, ADD telefono INT DEFAULT NULL, ADD como_conoce VARCHAR(255) DEFAULT NULL, ADD tipo_contacto VARCHAR(255) DEFAULT NULL, CHANGE info_inscripcion apellidos VARCHAR(255) DEFAULT NULL');
    }
}
