<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['$email_verified_at'] = Carbon::now();

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        /**@var \App\Models\User $user*/
        $user= parent::handleRecordCreation($data);
        return $user;
    }
}
