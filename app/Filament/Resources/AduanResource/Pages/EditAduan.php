<?php

namespace App\Filament\Resources\AduanResource\Pages;


use Filament\Actions;
use App\Models\AdminComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\AduanResource;

class EditAduan extends EditRecord
{
    protected static string $resource = AduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Jika status adalah 'Sedang Diproses' atau 'Selesai' dan ada komentar admin
        if (in_array($data['status'], ['Sedang Diproses', 'Selesai']) && isset($data['komentar_admin'])) {
            // Cek apakah sudah ada komentar untuk status ini
            $existingComment = AdminComment::where('aduan_id', $record->id)
                ->where('status_aduan', $data['status'])
                ->first();
            
            if ($existingComment) {
                // Update komentar yang sudah ada
                $existingComment->komentar = $data['komentar_admin'];
                $existingComment->user_id = Auth::id();
                $existingComment->save();
            } else {
                // Buat komentar baru
                AdminComment::create([
                    'aduan_id' => $record->id,
                    'komentar' => $data['komentar_admin'],
                    'user_id' => Auth::id(),
                    'status_aduan' => $data['status'],
                ]);
            }
            
            // Hapus komentar_admin dari data karena tidak ada di model Aduan
            unset($data['komentar_admin']);
            unset($data['user_id']);
            unset($data['status_aduan']);
        }
        
        // Update record aduan
        $record->update($data);
        
        return $record;
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Jika status adalah 'Sedang Diproses' atau 'Selesai', cari komentar yang sudah ada
        if (in_array($data['status'], ['Sedang Diproses', 'Selesai'])) {
            $existingComment = AdminComment::where('aduan_id', $this->record->id)
                ->where('status_aduan', $data['status'])
                ->latest()
                ->first();
            
            if ($existingComment) {
                // Isi field komentar_admin dengan komentar yang sudah ada
                $data['komentar_admin'] = $existingComment->komentar;
            }
        }
        
        return $data;
    }
}
