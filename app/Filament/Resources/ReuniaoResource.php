<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReuniaoResource\Pages;
use App\Models\Reuniao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Carbon\Carbon;

class ReuniaoResource extends Resource
{
 
    protected static ?string $model = \App\Models\Meeting::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    
    protected static ?string $navigationLabel = 'Reuniões';
    
    protected static ?string $modelLabel = 'Reunião';
    
    protected static ?string $pluralModelLabel = 'Reuniões';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações da Reunião')
                    ->schema([
                        Forms\Components\TextInput::make('titulo')
                            ->required()
                            ->maxLength(255)
                            ->label('Título'),
                        Forms\Components\Textarea::make('descricao')
                            ->required()
                            ->rows(3)
                            ->label('Descrição'),
                        Forms\Components\TextInput::make('tema_literario')
                            ->required()
                            ->maxLength(255)
                            ->label('Tema Literário'),
                        Forms\Components\FileUpload::make('imagem')
                            ->label('Imagem da Reunião')
                            ->image()
                            ->directory('reunioes')
                            ->maxSize(10240)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
                            ->helperText('Formatos aceitos: JPG, PNG, WEBP. Tamanho máximo: 10MB')
                            ->imageEditor()
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('675')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Livro Sugerido')
                    ->schema([
                        Forms\Components\TextInput::make('livro_sugerido')
                            ->maxLength(255)
                            ->label('Livro'),
                        Forms\Components\TextInput::make('autor_livro')
                            ->maxLength(255)
                            ->label('Autor'),
                    ])->columns(2),

                Forms\Components\Section::make('Data e Local')
                    ->schema([
                        Forms\Components\DateTimePicker::make('data_reuniao')
                            ->required()
                            ->label('Data da Reunião')
                            ->default(function () {
                                return Carbon::now()->addDays(7)->format('Y-m-d H:i');
                            })
                            ->format('Y-m-d H:i:s')
                            ->displayFormat('d/m/Y H:i')
                            ->native(false)
                            ->seconds(false)
                            ->minutesStep(15),
                        Forms\Components\TextInput::make('local')
                            ->required()
                            ->maxLength(255)
                            ->label('Local')
                            ->placeholder('Ex: Biblioteca Central, Sala 101'),
                        Forms\Components\TextInput::make('limite_participantes')
                            ->required()
                            ->numeric()
                            ->default(20)
                            ->label('Limite de Participantes')
                            ->minValue(1)
                            ->maxValue(100)
                            ->suffix('pessoas'),
                    ])->columns(3),

                Forms\Components\Section::make('Configurações')
                    ->schema([
                        Forms\Components\Toggle::make('ativa')
                            ->default(true)
                            ->label('Reunião Ativa')
                            ->helperText('Desmarque para desativar inscrições'),
                        Forms\Components\Textarea::make('observacoes')
                            ->rows(3)
                            ->label('Observações')
                            ->placeholder('Informações adicionais sobre a reunião...')
                            ->maxLength(1000),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagem')
                    ->label('Imagem')
                    ->circular()
                    ->size(50),
                    
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable()
                    ->sortable()
                    ->label('Título')
                    ->weight('bold')
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('tema_literario')
                    ->searchable()
                    ->label('Tema Literário')
                    ->limit(25)
                    ->color('primary'),
                    
                Tables\Columns\TextColumn::make('livro_sugerido')
                    ->searchable()
                    ->label('Livro')
                    ->limit(20)
                    ->placeholder('Não informado')
                    ->color('gray'),
                    
                Tables\Columns\TextColumn::make('data_reuniao')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->label('Data')
                    ->color(fn ($record) => $record->data_reuniao < now() ? 'danger' : 'success'),
                    
                Tables\Columns\TextColumn::make('local')
                    ->searchable()
                    ->label('Local')
                    ->limit(15),
                    
                Tables\Columns\TextColumn::make('total_inscritos')
                    ->label('Inscritos')
                    ->alignCenter()
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($record) => $record->total_inscritos . '/' . $record->limite_participantes),
                    
                Tables\Columns\IconColumn::make('ativa')
                    ->boolean()
                    ->label('Status')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('ativa')
                    ->label('Status da Reunião')
                    ->placeholder('Todas')
                    ->trueLabel('Apenas Ativas')
                    ->falseLabel('Apenas Inativas'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('data_reuniao', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReuniaos::route('/'),
            'create' => Pages\CreateReuniao::route('/create'),
            'edit' => Pages\EditReuniao::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('ativa', true)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}