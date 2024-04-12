<?php

namespace App\Filament\Resources;

use Exception;
use Carbon\Carbon;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Company;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Models\PermittedActivitie;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\KeyValue;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Leandrocfe\FilamentPtbrFormFields\Document;
use App\Filament\Resources\CompanyResource\Pages;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;


class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'fas-building-user';
    protected static ?string $navigationGroup = 'Empresas e Atividades';
    protected static ?string $navigationLabel = 'Consulta de Empresas';
    protected static ?string $modelLabel = 'Consulta Empresa';
    protected static ?string $modelLabelPlural = "Consultas";
    protected static ?int $navigationSort = 1;
    public static bool $formActionsAreSticky = true;

    public static function getEloquentQuery(): Builder
    {
            if(auth()->user()->is_admin === 1){
                return parent::getEloquentQuery();
            }else{
                return parent::getEloquentQuery()->where('user_id', auth()->id());
            }

        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Informações Principais da empresa')
                    ->schema([
                        Document::make('document_number')
                            ->label('CNPJ')
                            ->cnpj()
                            ->validation(true)
                            ->required()
                            ->columnSpan(2)
                            ->suffixAction(
                                fn ($state, $set) => Forms\Components\Actions\Action::make('search-action')
                                    ->icon('heroicon-s-magnifying-glass')
                                    ->action(function () use ($state, $set) {
                                        if (blank($state)) {
                                            Notification::make()
                                                ->title('Digite o CNPJ para bucar o fornecedor')
                                                ->danger()
                                                ->send();
                                            return;
                                        }
                                        try {
                                            //Formatar CNPJ para retirada de caracteres especiais
                                            $state = trim($state);
                                            $state = str_replace(array('.', '-', '/'), "", $state);

                                            //Token de acesso
                                            $CNPJ_TOKEN = env('HUB_DEV_TOKEN');

                                            //Chamada API CNPJ
                                            $cnpjData = Http::get(
                                                //"http://ws.hubdodesenvolvedor.com.br/v2/cnpj/?cnpj={$state}&token={$CNPJ_TOKEN}",

                                                "https://publica.cnpj.ws/cnpj/{$state}"
                                            )->throw()->json();

                                            if (Str::title($cnpjData['estabelecimento']['situacao_cadastral']) === "Baixada" or Str::title($cnpjData['estabelecimento']['situacao_cadastral']) === "Inapta") {
                                                Notification::make()
                                                    ->title('Atenção!!!')
                                                    ->body('CNPJ com Problema o mesmo encontra-se ' . Str::title($cnpjData['estabelecimento']['situacao_cadastral']))
                                                    ->danger()
                                                    ->send();
                                            } else {
                                                //Dados para tabela de empresa
                                                $set('social_reason', Str::title($cnpjData['razao_social']));
                                                $set('fantasy_name',  Str::title($cnpjData['estabelecimento']['nome_fantasia']));
                                                $set('open_date', Carbon::parse($cnpjData['estabelecimento']['data_inicio_atividade'])->format('d/m/Y'));
                                                $set('status',  Str::title($cnpjData['estabelecimento']['situacao_cadastral']));
                                                $set('company_size',  Str::title($cnpjData['porte']['descricao']));
                                                $set('legal_nature',  Str::title($cnpjData['natureza_juridica']['descricao']));
                                                $set('share_capital',  Str::title($cnpjData['capital_social']));
                                                $set('email', $cnpjData['estabelecimento']['email']);
                                                $set('phone', $cnpjData['estabelecimento']['ddd1'] . ' ' . $cnpjData['estabelecimento']['telefone1']);

                                                if ($cnpjData['simples'] === null) {
                                                    $cnpjData['simples']['simples'] = 'Não';
                                                    $cnpjData['simples']['mei'] = 'Não';
                                                }

                                                $set('simple_situation', $cnpjData['simples']['simples']);
                                                $set('simei_situation', $cnpjData['simples']['mei']);
                                                $set('principal_cnae_description',  Str::title($cnpjData['estabelecimento']['atividade_principal']['descricao']));
                                                $set('principal_cnae_code', $cnpjData['estabelecimento']['atividade_principal']['subclasse']);

                                                //dados para tabela de endereço da empresa
                                                $set('company_address.zip_code', $cnpjData['estabelecimento']['cep']);
                                                $set('company_address.street',  Str::title($cnpjData['estabelecimento']['tipo_logradouro'] . ' ' . $cnpjData['estabelecimento']['logradouro']));
                                                $set('company_address.number', $cnpjData['estabelecimento']['numero']);
                                                $set('company_address.district',  Str::title($cnpjData['estabelecimento']['bairro']));
                                                $set('company_address.city',  Str::title($cnpjData['estabelecimento']['cidade']['nome']));
                                                $set('company_address.state', $cnpjData['estabelecimento']['estado']['nome']);
                                                $set('company_address.complement', $cnpjData['estabelecimento']['complemento']);

                                                if ($cnpjData['simples']['mei'] === "Sim") {
                                                    $set('released', "Não");
                                                    Notification::make()
                                                        ->title('Atenção!!!')
                                                        ->body('Empresa enquadrada no MEI, Não faz parte do nosso escopo')
                                                        ->danger()
                                                        ->send();
                                                } elseif ($cnpjData['simples']['mei'] === "Não" && $cnpjData['simples']['simples'] === "Não") {
                                                    $set('released', "Sim");
                                                    Notification::make()
                                                        ->title('Liberado!!!')
                                                        ->body('Empresa liberada para Contato')
                                                        ->success()
                                                        ->send();
                                                } else {

                                                    $query = PermittedActivitie::select('name')->where('name', '=', $cnpjData['estabelecimento']['atividade_principal']['subclasse'])->first();

                                                    if ($query === null) {

                                                        foreach ($cnpjData['estabelecimento']['atividades_secundarias'] as $value) {
                                                            $query = PermittedActivitie::select('name')->where('name', '=', $value['subclasse'])->first();

                                                            if ($query === null) {
                                                                $set('released', "Não");
                                                                $cnae = $value['subclasse'];
                                                                $valida_cnae = false;
                                                            } else {
                                                                $set('released', "Sim");
                                                                $cnae = $value['subclasse'];
                                                                $valida_cnae = true;
                                                                break;
                                                            }
                                                        }

                                                        if ($valida_cnae === false) {
                                                            $set('released', "Não");
                                                            Notification::make()
                                                                ->title('Atenção!!!')
                                                                ->body('nenhum CNAE se enquadrado no anexo IV')
                                                                ->danger()
                                                                ->send();
                                                        } else {
                                                            $set('released', "Sim");
                                                            Notification::make()
                                                                ->title('Liberado!!!')
                                                                ->body('Empresa Possui CNAE no Anexo IV ' . ' - ' . $cnae)
                                                                ->success()
                                                                ->send();
                                                        }
                                                    } else {
                                                        $set('released', "Sim");
                                                        Notification::make()
                                                            ->title('Liberado!!!')
                                                            ->body('Empresa Possui CNAE Pincipal no Anexo IV ' . ' - ' . $cnpjData['estabelecimento']['atividade_principal']['subclasse'])
                                                            ->success()
                                                            ->send();
                                                    }
                                                }
                                                //dados para tabela de Atividades secundarias da empresa
                                                foreach ($cnpjData['estabelecimento']['atividades_secundarias'] as $key => $value) {

                                                    $set("secondary_activities.secondary_activitie.{$value['subclasse']}", $value['descricao']);
                                                }
                                            }
                                        } catch (Exception $e) {
                                            Notification::make()
                                                ->title('CNPJ inválido')
                                                ->danger()
                                                ->send();
                                        }
                                    })
                            ),

                        Hidden::make('user_id')
                            ->default(auth()->user()->id),    

                        TextInput::make('status')
                            ->label('Situação CNPJ')
                            ->columnSpan(1)
                            ->maxLength(255),
                        TextInput::make('simple_situation')
                            ->label('Simples Nacional')
                            ->columnSpan(1)
                            ->maxLength(255),
                        TextInput::make('simei_situation')
                            ->label('MEI')
                            ->columnSpan(1)
                            ->maxLength(255),
                        TextInput::make('open_date')
                            ->label('Data de Abertura')
                            ->columnSpan(1)
                            ->maxLength(255),
                        TextInput::make('social_reason')
                            ->label('Razão Social')
                            ->columnSpan(3)
                            ->required()
                            ->maxLength(255),
                        TextInput::make('fantasy_name')
                            ->label('Nome Fantasia')
                            ->columnSpan(3)
                            ->maxLength(255),
                        TextInput::make('company_size')
                            ->label('Tamanho da Empresa')
                            ->columnSpan(1)
                            ->maxLength(255),
                        Money::make('share_capital')
                            ->label('Capital Declarado')
                            ->columnSpan(2)
                            ->maxLength(255),
                        TextInput::make('legal_nature')
                            ->label('Natureza Juridica')
                            ->columnSpan(2)
                            ->maxLength(255),
                        TextInput::make('released')
                            ->label('Apta para Contato')
                            ->columnSpan(1)
                            ->maxLength(255),
                    ])->columns(6),

                Fieldset::make('CNAE Principal')
                    ->schema([
                        TextInput::make('principal_cnae_code')
                            ->columnSpan(1)
                            ->label('Código CNAE')
                            ->maxLength(255),
                        TextInput::make('principal_cnae_description')
                            ->label('Descrição do CNAE')
                            ->columnSpan(3)
                            ->maxLength(255),
                    ])->columns(5),

                Fieldset::make('CNAEs Secundários')
                    ->relationship('secondary_activities')
                    ->schema([
                        KeyValue::make('secondary_activitie')
                            ->label('')
                            ->keyLabel('CNAE')
                            ->valueLabel('Descrição')
                            ->deletable(false)
                            ->addable(false)
                            ->editableKeys(false)
                            ->columnSpan(6)
                    ])->columns(6),

                Fieldset::make('Contatos')
                    ->schema([
                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->maxLength(255),
                        PhoneNumber::make('phone')
                            ->label('Telefone Fixo')
                            ->format('(99)9999-9999')
                            ->maxLength(255),
                        PhoneNumber::make('cellphone')
                            ->label('Telefone Celular')
                            ->format('(99)99999-9999')
                            ->maxLength(255),
                    ])->columns(3),

                Fieldset::make('Informações de Endereço')
                    ->relationship('company_address')
                    ->schema([
                        TextInput::make('zip_code')
                            ->label('CEP')
                            ->columnSpan(1),
                        TextInput::make('street')
                            ->label('Logradouro')
                            ->columnSpan(2)
                            ->required()
                            ->maxLength(255),
                        TextInput::make('number')
                            ->label('Numero')
                            ->columnSpan(1)
                            ->required()
                            ->maxLength(255),
                        TextInput::make('complement')
                            ->label('Complemento')
                            ->columnSpan(2)
                            ->maxLength(255),
                        TextInput::make('reference')
                            ->label('Referência')
                            ->columnSpan(4)
                            ->maxLength(255),

                        Fieldset::make()
                            ->schema([
                                TextInput::make('district')
                                    ->label('Bairro')
                                    ->columnSpan(1)
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('city')
                                    ->label('Cidade')
                                    ->columnSpan(1)
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('state')
                                    ->label('Estado')
                            ])->columns(3),
                    ])->columns(6),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            
            ->columns([
                TextColumn::make('released')
                    ->label('Apta para Contato')
                    ->badge()
                    ->alignCenter()
                    ->color(fn (string $state): string => match ($state) {
                        'Sim' => 'success',
                        'Não' => 'danger',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('document_number')
                    ->label('CNPJ')
                    ->alignCenter()
                    ->searchable(),
                TextColumn::make('social_reason')
                    ->label('Razão Social')
                    ->searchable(),
                TextColumn::make('status')
                    ->alignCenter()
                    ->label('Status CNPJ')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->alignCenter()
                    ->label('Usuário')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('company_address.city')
                    ->label('Cidade')
                    ->alignCenter()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('released')
                    ->label('Apta para contato')
                    ->options([
                        'Sim' => 'Sim',
                        'Não' => 'Não',
                    ]),
                    SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Usuário')
                    ->multiple()
                    ->preload()
                    ->options([
                        User::query()->pluck('name', 'id')->toArray()
                    ])
                
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
            'view' => Pages\ViewCompany::route('/{record}'),
        ];
    }
}
