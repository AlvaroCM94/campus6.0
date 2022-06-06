<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220525224651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario_curso DROP INDEX UNIQ_D7E52AF27EB2C349, ADD INDEX IDX_D7E52AF27EB2C349 (id_usuario_id)');
        $this->addSql('ALTER TABLE usuario_curso DROP INDEX UNIQ_D7E52AF2D710A68A, ADD INDEX IDX_D7E52AF2D710A68A (id_curso_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario_curso DROP INDEX IDX_D7E52AF27EB2C349, ADD UNIQUE INDEX UNIQ_D7E52AF27EB2C349 (id_usuario_id)');
        $this->addSql('ALTER TABLE usuario_curso DROP INDEX IDX_D7E52AF2D710A68A, ADD UNIQUE INDEX UNIQ_D7E52AF2D710A68A (id_curso_id)');
    }
}
