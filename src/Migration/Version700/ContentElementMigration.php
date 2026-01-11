<?php

declare(strict_types=1);

/*
 * This file is part of Fontawesome Icon Picker Bundle.
 *
 * (c) Marko Cupic <m.cupic@gmx.ch>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/fontawesome-icon-picker-bundle
 */

namespace Markocupic\FontawesomeIconPickerBundle\Migration\Version700;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;

/**
 * @internal
 */
class ContentElementMigration extends AbstractMigration
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->createSchemaManager();

        if (!$schemaManager->tablesExist(['tl_content'])) {
            return false;
        }

        $columns = $schemaManager->listTableColumns('tl_content');

        if (!isset($columns['id']) || !isset($columns['faicon'])) {
            return false;
        }

        $runMigration = false;

        $query = $this->buildQueryWithParams();

        $result = $this->connection->fetchOne($query['sql'], $query['params']);

        if (false !== $result) {
            $runMigration = true;
        }

        return $runMigration;
    }

    public function run(): MigrationResult
    {
        $styles = $this->getMap();

        $query = $this->buildQueryWithParams();
        $rows = $this->connection->fetchAllAssociative($query['sql'], $query['params']);

        foreach ($rows as $row) {
            $icon = StringUtil::deserialize($row['faIcon']);

            if (!empty($icon[1]) && isset($styles[$icon[1]])) {
                $icon[1] = $styles[$icon[1]];

                $set = [
                    'faIcon' => serialize($icon),
                ];

                $this->connection->update('tl_content', $set, ['id' => $row['id']]);
            }
        }

        return $this->createResult(true);
    }

    protected function buildQueryWithParams(): array
    {
        $styles = array_keys($this->getMap());

        $where = [];
        $params = [];

        foreach ($styles as $style) {
            $where[] = 'faIcon LIKE ?';
            $params[] = '%"'.$style.'"%';
        }

        return [
            'sql' => 'SELECT id, faIcon FROM tl_content WHERE faIcon IS NOT NULL AND '.implode(' OR ', $where),
            'params' => $params,
        ];
    }

    protected function getMap(): array
    {
        return [
            'far' => 'fa-regular',
            'fas' => 'fa-solid',
            'fal' => 'fa-light',
            'fat' => 'fa-thin',
            'fad' => 'fa-duotone',
            'fab' => 'fa-brands',
        ];
    }
}
