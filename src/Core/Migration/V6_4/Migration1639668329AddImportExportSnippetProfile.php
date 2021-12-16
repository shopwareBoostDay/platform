<?php declare(strict_types=1);

namespace Shopware\Core\Migration\V6_4;

use Doctrine\DBAL\Connection;
use Shopware\Core\Content\ImportExport\ImportExportProfileTranslationDefinition;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Migration\MigrationStep;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\Migration\Traits\ImportTranslationsTrait;
use Shopware\Core\Migration\Traits\Translations;

class Migration1639668329AddImportExportSnippetProfile extends MigrationStep
{
    use ImportTranslationsTrait;

    public function getCreationTimestamp(): int
    {
        return 1639668329;
    }

    public function update(Connection $connection): void
    {
        $id = Uuid::randomBytes();

        $connection->insert('import_export_profile', [
            'id' => $id,
            'name' => 'Default snippet',
            'system_default' => 1,
            'source_entity' => 'snippet',
            'file_type' => 'text/csv',
            'delimiter' => ';',
            'enclosure' => '"',
            'type' => 'import-export',
            'mapping' => json_encode([
                ['key' => 'id', 'mappedKey' => 'id', 'position' => 0],
                ['key' => 'setId', 'mappedKey' => 'set_id', 'position' => 1],
                ['key' => 'translationKey', 'mappedKey' => 'translation_key', 'position' => 2],
                ['key' => 'value', 'mappedKey' => 'value', 'position' => 3],
                ['key' => 'author', 'mappedKey' => 'author', 'position' => 4],
            ]),
            'created_at' => (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);

        $translations = new Translations(
            [
                'import_export_profile_id' => $id,
                'label' => 'Standardprofil Snippets',
            ],
            [
                'import_export_profile_id' => $id,
                'label' => 'Default snippets',
            ]
        );

        $this->importTranslation(ImportExportProfileTranslationDefinition::ENTITY_NAME, $translations, $connection);
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
