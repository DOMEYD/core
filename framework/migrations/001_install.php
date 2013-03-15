<?php
namespace Nos\Migrations;

class Install extends \Nos\Migration
{
    public function up()
    {
        // test if there exists old migrations migrations
        $old_migration = \DB::query('SELECT * FROM nos_migration WHERE
        type = "app" AND name="default" AND migration="001_installation_0_1";')->execute();
        if (count($old_migration) > 0) {
            $sql_file_legacy = substr($this->path, 0, strlen($this->path) - 4).'_legacy.sql';
            static::executeSqlFile($sql_file_legacy);
            \Config::set('migrations.version.app.default', array());
            \Config::set('migrations.version.package', array(
                'nos' =>
                array(
                    0 => '001_install',
                    1 => '002_version_0_2',
                    2 => '003_move_migration_table',
                ),
            ));
            \Config::set('migrations.version.module', array(
                'noviusos_media' =>
                array(
                    0 => '001_install',
                    1 => '002_migrate_0_1_1',
                ),
                'noviusos_page' =>
                array(
                    0 => '001_install',
                    1 => '002_migrate_0_1_1',
                    2 => '003_version_0_2',
                ),
                'noviusos_user' =>
                array(
                    0 => '001_install',
                    1 => '002_migrate_0_1_1',
                    2 => '003_version_0_2',
                ),
                'noviusos_templates_basic' =>
                array(
                    0 => '001_version_0_2',
                ),
            ));

        } else {
            parent::up();
        }
    }
}