<?php

namespace Workbench\App\Filament\Resources\Users\Pages;

use Workbench\App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
