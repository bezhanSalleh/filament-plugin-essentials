<?php

namespace Workbench\App\Filament\Resources\Users\Pages;

use Filament\Resources\Pages\CreateRecord;
use Workbench\App\Filament\Resources\Users\UserResource;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
