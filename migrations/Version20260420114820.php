<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260420114820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment ADD user_id INT NOT NULL, ADD asset_id INT DEFAULT NULL, ADD consumable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA5DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BAA94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id)');
        $this->addSql('CREATE INDEX IDX_30C544BAA76ED395 ON assignment (user_id)');
        $this->addSql('CREATE INDEX IDX_30C544BA5DA1941 ON assignment (asset_id)');
        $this->addSql('CREATE INDEX IDX_30C544BAA94ADB61 ON assignment (consumable_id)');
        $this->addSql('ALTER TABLE history ADD user_id INT NOT NULL, ADD asset_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704B5DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id)');
        $this->addSql('CREATE INDEX IDX_27BA704BA76ED395 ON history (user_id)');
        $this->addSql('CREATE INDEX IDX_27BA704B5DA1941 ON history (asset_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BAA76ED395');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA5DA1941');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BAA94ADB61');
        $this->addSql('DROP INDEX IDX_30C544BAA76ED395 ON assignment');
        $this->addSql('DROP INDEX IDX_30C544BA5DA1941 ON assignment');
        $this->addSql('DROP INDEX IDX_30C544BAA94ADB61 ON assignment');
        $this->addSql('ALTER TABLE assignment DROP user_id, DROP asset_id, DROP consumable_id');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BA76ED395');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704B5DA1941');
        $this->addSql('DROP INDEX IDX_27BA704BA76ED395 ON history');
        $this->addSql('DROP INDEX IDX_27BA704B5DA1941 ON history');
        $this->addSql('ALTER TABLE history DROP user_id, DROP asset_id');
    }
}
