<?php
declare(strict_types=1);

namespace Shopware\Core\Migration\Test;

use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\Test\TestCaseBase\IntegrationTestBehaviour;
use Shopware\Core\Migration\V6_4\Migration1639668329AddImportExportSnippetProfile;

class Migration1639668329AddImportExportSnippetProfileTest extends TestCase
{
    use IntegrationTestBehaviour;

    private Connection $connection;

    protected function setUp(): void
    {
        $this->connection = $this->getContainer()->get(Connection::class);
        $this->connection->executeStatement('DELETE FROM `import_export_profile` WHERE `source_entity` = "snippet"');
    }

    public function testMigration(): void
    {
        $migration = new Migration1639668329AddImportExportSnippetProfile();

        static::assertFalse($this->getSnippetProfileId());

        $migration->update($this->connection);

        $id = $this->getSnippetProfileId();
        static::assertNotFalse($id);
        static::assertEquals(2, $this->getSnippetProfileTranslations($id));
    }

    private function getSnippetProfileId()
    {
        return $this->connection->fetchOne('SELECT `id` FROM `import_export_profile` WHERE `source_entity` = "snippet"');
    }

    private function getSnippetProfileTranslations(string $id): int
    {
        return (int) $this->connection->fetchOne(
            'SELECT COUNT(`import_export_profile_id`) FROM `import_export_profile_translation` WHERE `import_export_profile_id` = :id',
            ['id' => $id]
        );
    }
}
