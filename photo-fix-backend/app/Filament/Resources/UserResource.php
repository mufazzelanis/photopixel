<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\GloballySearchable;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    use GloballySearchable;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $navigationLabel = 'Staff Users';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    protected static array $globalSearch = ['name', 'email'];

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(120),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(190)
                ->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('password')
                ->password()
                ->revealable()
                ->minLength(8)
                ->required(fn (string $context): bool => $context === 'create')
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                ->helperText(fn (string $context): string => $context === 'edit'
                    ? 'Leave blank to keep the current password.'
                    : 'At least 8 characters.'),
            Forms\Components\Select::make('roles')
                ->relationship('roles', 'name')
                ->multiple()
                ->preload()
                ->searchable()
                ->required()
                ->helperText('What this person can see and do in the admin panel is controlled entirely by their role(s) — manage those under User Management → Roles.')
                // A non-super-admin can hand out roles, but never the Super
                // Admin role itself — that would be a privilege escalation.
                ->options(function () {
                    /** @var \App\Models\User|null $viewer */
                    $viewer = Auth::user();
                    $query = Role::query();
                    if (! $viewer?->hasRole(config('filament-shield.super_admin.name', 'super_admin'))) {
                        $query->where('name', '!=', config('filament-shield.super_admin.name', 'super_admin'));
                    }

                    return $query->pluck('name', 'id');
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->weight('bold')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->separator(',')
                    ->color(fn (string $state): string => $state === config('filament-shield.super_admin.name', 'super_admin') ? 'danger' : 'primary'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('M j, Y')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    // Never let anyone delete their own account from this table —
                    // the only way to lose panel access entirely would be to lock
                    // yourself out with no other super admin left to fix it.
                    ->visible(fn (User $record): bool => $record->getKey() !== Auth::id()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('roles');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
