<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.commission', 2);
        $this->migrator->add('general.commission_unit','%');
        $this->migrator->add('general.app_name','DigiFarmer');
        $this->migrator->add('general.currency_unit','UGX');
    }
}
