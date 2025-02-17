<?php
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Login as BaseAuth;

class Login extends BaseAuth
{
public function form(Form $form): Form
{
return $form
->schema([
$this->getLoginFormComponent(),
$this->getPasswordFormComponent(),
$this->getRememberFormComponent(),
])
->statePath('data');
}

protected function getLoginFormComponent(): Component
{
return TextInput::make('login')
->label('Login')
->required()
->autocomplete()
->autofocus()
->extraInputAttributes(['tabindex' => 1]);
}
}
