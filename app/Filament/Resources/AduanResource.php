<?php

namespace App\Filament\Resources;

use Dom\Text;
use Filament\Forms;
use Filament\Tables;
use App\Models\Aduan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AduanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AduanResource\RelationManagers;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminComment;

class AduanResource extends Resource
{
    protected static ?string $model = Aduan::class;

    protected static?string $slug = 'aduan';

    protected static?string $navigationLabel = 'Aduan';

    protected static?string $pluralLabel = 'Aduan Masyarakat';

    protected static ?string $title = 'Aduan Masyarakat';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Aduan')
                    ->schema([
                        TextInput::make('tiket')
                            ->label('Nomor Tiket (Otomatis Generate)')
                            ->disabled(),
                        TextInput::make('judul')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('isi')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('jenis')
                            ->label('Jenis Aduan')
                            ->options([
                                'Infrastruktur' => 'Infrastruktur',
                                'Lingkungan' => 'Lingkungan',
                                'Pelayanan Publik' => 'Pelayanan Publik',
                                'Keamanan' => 'Keamanan',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->required(),
                        
                        TextInput::make('lokasi')
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('lampiran')
                            ->image()
                            ->directory('lampiran')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ])->columns(2),
                
                Section::make('Status Aduan')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'Pending' => 'Pending',
                                'Sedang Diproses' => 'Sedang Diproses',
                                'Selesai' => 'Selesai',
                            ])
                            ->default('Pending')
                            ->required()
                            ->reactive(),
                        
                        // Menampilkan komentar sebelumnya untuk status yang dipilih
                        Placeholder::make('komentar_sebelumnya')
                            ->label('Komentar Sebelumnya')
                            ->content(function (Aduan $record, callable $get) {
                                $status = $get('status');
                                if (in_array($status, ['Sedang Diproses', 'Selesai'])) {
                                    $comment = AdminComment::where('aduan_id', $record->id)
                                        ->where('status_aduan', $status)
                                        ->latest()
                                        ->first();
                                    
                                    if ($comment) {
                                        return $comment->komentar . ' (' . $comment->created_at->format('d M Y H:i') . ')';
                                    }
                                    
                                    return 'Belum ada komentar untuk status ini';
                                }
                                
                                return 'Pilih status Sedang Diproses atau Selesai untuk melihat komentar';
                            })
                            ->visible(fn (callable $get) => in_array($get('status'), ['Sedang Diproses', 'Selesai'])),
                        
                        Textarea::make('komentar_admin')
                            ->label('Komentar Admin')
                            ->required()
                            ->visible(fn (callable $get) => in_array($get('status'), ['Sedang Diproses', 'Selesai']))
                            ->helperText(fn (callable $get) => 
                                $get('status') === 'Sedang Diproses' 
                                    ? 'Berikan informasi tentang proses penanganan aduan ini' 
                                    : 'Berikan informasi tentang penyelesaian aduan ini'
                            ),
                        
                        Hidden::make('user_id')
                            ->default(fn () => Auth::id()),
                        
                        Hidden::make('status_aduan')
                            ->default(fn (callable $get) => $get('status')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tiket')->searchable()
                    ->copyable()
                    ->copyMessage('Nomor tiket berhasil disalin')
                    ->copyMessageDuration(1500)
                    ->icon('heroicon-o-clipboard')
                    ->disabled(),
                TextColumn::make('judul')->searchable()
                    ->disabled(),
                TextColumn::make('isi')->searchable()
                    ->limit(50)
                    ->disabled(),
                TextColumn::make('jenis')->searchable()
                    ->disabled(),
                TextColumn::make('status')->searchable(),
                ImageColumn::make('lampiran')
                    ->label('Lampiran')
                    ->width(50)
                    ->height(50)
                    ->disabled(),
                TextColumn::make('created_at')->dateTime('d M Y')->sortable()
                    ->disabled(),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                
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
            'index' => Pages\ListAduans::route('/'),
            'create' => Pages\CreateAduan::route('/create'),
            'edit' => Pages\EditAduan::route('/{record}/edit'),
        ];
    }
}
