<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 1;

    // public static function viewAny(User $user): bool
    // {
    //     return $user->hasRole('admin');
    // }

    // protected static ?bool $shouldRegisterNavigation = auth()->user()->can('view-appointments');

    public static function getNavigationBadge(): ?string
    {
        if (Auth::user()->hasRole('patient')) {
            return static::getModel()::where('patient_id', '=', auth()->user()->id)->count();
        } elseif (Auth::user()->hasRole('doctor')) {
            return static::getModel()::where('doctor_id', '=', auth()->user()->id)->count();
        }

        return static::getModel()::count();
    }

    public static function getEloquentQuery(): Builder
    {
        if (Auth::user()->hasRole('patient')) {
            return parent::getEloquentQuery()->where('patient_id', auth()->user()->id);
        } elseif (Auth::user()->hasRole('doctor')) {
            return parent::getEloquentQuery()->where('doctor_id', auth()->user()->id);
        }
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('institution')->required(),
                        TextInput::make('department')->required()
                    ])->columns(3),
                Section::make('Patient and Doctor')
                    ->schema([
                        Select::make('patient_id')
                            ->relationship(
                                name: 'patient',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->role('patient'),
                            )
                            ->required(),
                        Select::make('doctor_id')
                            ->relationship(
                                name: 'doctor',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->role('doctor'),
                            )
                            ->required()
                    ])->columns(2),
                Section::make('Time')
                    ->schema([
                        DateTimePicker::make('appointment_start_time'),
                        DateTimePicker::make('appointment_end_time')
                            ->after('appointment_start_time')
                    ])->columns(2),
                Section::make('Other')
                    ->schema([
                        MarkdownEditor::make('description'),
                        MarkdownEditor::make('notes')
                    ])->columns(2)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('patient.name')->searchable()->sortable()->toggleable(),
                TextColumn::make('doctor.name')->searchable()->sortable()->toggleable(),
                TextColumn::make('institution')->searchable()->sortable(),
                TextColumn::make('created_at')->label('Created At')->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
