<?php

namespace App\Filament\Auth;

use Dom\Comment;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Http\Responses\Auth\LoginResponse;
use Filament\Pages\Auth\Login;
use Illuminate\Validation\ValidationException;

class CustomLogin extends Login
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getUsernameFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('username')
                ->label('Username / ID Karyawan')
                ->required()
                ->autocomplete()
                ->autofocus(),

            TextInput::make('password')
                ->label(__('Password'))
                ->password()
                ->required(),
        ];
    }

    protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->label(__('Username / ID Karyawan'))
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.username' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);

    }

    // public function authenticate(): LoginResponse
    // {
    //     $credentials = $this->getCredentialsFromFormData($this->data);

    //     if (!auth()->attempt($credentials)) {
    //         dd($credentials, \App\Models\User::where('username', $credentials['username'])->first());
    //     }

    //     session()->regenerate();
    // }

}
