<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InscricaoResource\Pages;
use App\Models\Inscricao;
use App\Models\User;
use App\Models\Reuniao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InscricaoResource extends Resource
{
    protected static ?string $model = Inscricao::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationLabel = 'Inscrições';
    
    protected static ?string $modelLabel = 'Inscrição';
    
    protected static ?string $pluralModelLabel = 'Inscrições';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dados da Inscrição')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Usuário')
                            ->options(User::all()->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->placeholder('Selecione um usuário'),
                            
                        Forms\Components\Select::make('reuniao_id')
                            ->label('Reunião')
                            ->options(function () {
                                return Reuniao::where('ativa', true)
                                    ->orderBy('data_reuniao')
                                    ->get()
                                    ->mapWithKeys(function ($reuniao) {
                                        return [$reuniao->id => $reuniao->titulo . ' - ' . $reuniao->data_reuniao->format('d/m/Y H:i')];
                                    });
                            })
                            ->required()
                            ->searchable()
                            ->placeholder('Selecione uma reunião'),
                            
                        Forms\Components\DateTimePicker::make('data_inscricao')
                            ->label('Data da Inscrição')
                            ->default(now())
                            ->required(),
                    ])->columns(1),

                Forms\Components\Section::make('Informações Adicionais')
                    ->schema([
                        Forms\Components\Textarea::make('comentarios')
                            ->label('Comentários')
                            ->rows(3)
                            ->placeholder('Comentários ou observações sobre a inscrição...'),
                            
                        Forms\Components\Toggle::make('confirmada')
                            ->label('Inscrição Confirmada')
                            ->default(false)
                            ->helperText('Marque se a inscrição foi confirmada pelo administrador'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copiado!')
                    ->copyMessageDuration(1500),
                    
                Tables\Columns\TextColumn::make('reuniao.titulo')
                    ->label('Reunião')
                    ->sortable()
                    ->searchable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('reuniao.data_reuniao')
                    ->label('Data da Reunião')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->color('primary'),
                    
                Tables\Columns\TextColumn::make('data_inscricao')
                    ->label('Data Inscrição')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since()
                    ->color('gray'),
                    
                Tables\Columns\IconColumn::make('confirmada')
                    ->label('Confirmada')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),
                    
                Tables\Columns\TextColumn::make('comentarios')
                    ->label('Comentários')
                    ->limit(20)
                    ->placeholder('Nenhum comentário'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('confirmada')
                    ->label('Status da Inscrição')
                    ->placeholder('Todas')
                    ->trueLabel('Apenas Confirmadas')
                    ->falseLabel('Apenas Pendentes'),
                    
                Tables\Filters\SelectFilter::make('reuniao_id')
                    ->label('Reunião')
                    ->options(function () {
                        return Reuniao::orderBy('data_reuniao', 'desc')
                            ->limit(20)
                            ->pluck('titulo', 'id');
                    })
                    ->placeholder('Todas as reuniões'),
                    
                Tables\Filters\Filter::make('data_inscricao')
                    ->form([
                        Forms\Components\DatePicker::make('inscrito_de')
                            ->label('Inscrito de'),
                        Forms\Components\DatePicker::make('inscrito_ate')
                            ->label('Inscrito até'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['inscrito_de'], fn($query, $date) => $query->whereDate('data_inscricao', '>=', $date))
                            ->when($data['inscrito_ate'], fn($query, $date) => $query->whereDate('data_inscricao', '<=', $date));
                    })
                    ->label('Período de Inscrição'),
            ])
            ->actions([
                Tables\Actions\Action::make('confirmar')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function (Inscricao $record) {
                        $record->update(['confirmada' => true]);
                    })
                    ->visible(fn (Inscricao $record) => !$record->confirmada)
                    ->label('Confirmar'),
                    
                Tables\Actions\Action::make('cancelar_confirmacao')
                    ->icon('heroicon-o-x-mark')
                    ->color('warning')
                    ->action(function (Inscricao $record) {
                        $record->update(['confirmada' => false]);
                    })
                    ->visible(fn (Inscricao $record) => $record->confirmada)
                    ->label('Cancelar Confirmação'),
                    
                Tables\Actions\EditAction::make()
                    ->label('Editar'),
                    
                Tables\Actions\DeleteAction::make()
                    ->label('Excluir'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('confirmar_selecionadas')
                        ->label('Confirmar Selecionadas')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['confirmada' => true]);
                        }),
                        
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Excluir Selecionadas'),
                ]),
            ])
            ->defaultSort('data_inscricao', 'desc')
            ->striped()
            ->paginated([10, 25, 50]);
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
            'index' => Pages\ListInscricaos::route('/'),
            'create' => Pages\CreateInscricao::route('/create'),
            'edit' => Pages\EditInscricao::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('confirmada', false)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}