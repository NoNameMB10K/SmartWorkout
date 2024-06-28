<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628184940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51CC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_AEDAD51CC54C8C93 ON exercise (type_id)');
        $this->addSql('ALTER TABLE workout ADD user_id INT NOT NULL, ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB72A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB72C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_649FFB72A76ED395 ON workout (user_id)');
        $this->addSql('CREATE INDEX IDX_649FFB72C54C8C93 ON workout (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise DROP FOREIGN KEY FK_AEDAD51CC54C8C93');
        $this->addSql('DROP INDEX IDX_AEDAD51CC54C8C93 ON exercise');
        $this->addSql('ALTER TABLE exercise DROP type_id');
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB72A76ED395');
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB72C54C8C93');
        $this->addSql('DROP INDEX IDX_649FFB72A76ED395 ON workout');
        $this->addSql('DROP INDEX IDX_649FFB72C54C8C93 ON workout');
        $this->addSql('ALTER TABLE workout DROP user_id, DROP type_id');
    }
}
