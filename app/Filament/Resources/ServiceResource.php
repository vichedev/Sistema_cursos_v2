<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Titulo del curso')
                    ->required(),
                TextInput::make('icon_class')
                    ->label('Foto del curso')
                    ->required(),
                TextInput::make('short_desc')
                    ->label('Breve descripción')
                    ->required(),
                RichEditor::make('description')->columnSpan(2)
                    ->label('Descripción Larga'),
                FileUpload::make('img_course')->columnSpan(2)
                    ->label('Imagen del curso')
                    ->image() // Indica que el archivo subido debe ser una imagen
                    ->disk('public') // Especifica el disco donde se guardará la imagen
                    ->directory('uploads/courses') // Especifica el directorio donde se guardarán las imágenes
                    ->required(),
                Select::make('status')->options([
                    1 => 'Active',
                    0 => 'Block',
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('img_course')
                    ->label('Imagen del curso')
                    ->disk('public'), // Especifica el disco donde se guardarán las imágenes
                TextColumn::make('title')->label('ZONA DE CURSOS'),
                TextColumn::make('short_desc')->label('CATEGORIA'),
                TextColumn::make('status')->label('ESTATUS'),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
