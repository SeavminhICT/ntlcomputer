<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function show()
    {
        $url = config('store.catalog_url') ?: route('catalog.index');
        $path = $this->generateQrCode($url);

        return view('admin.qr.show', [
            'qrPath' => Storage::url($path),
            'catalogUrl' => $url,
        ]);
    }

    public function download()
    {
        $url = config('store.catalog_url') ?: route('catalog.index');
        $path = $this->generateQrCode($url);

        return Storage::disk('public')->download($path, 'catalog-qr.svg');
    }

    private function generateQrCode(string $url): string
    {
        $path = 'qr/catalog-qr.svg';

        if (! Storage::disk('public')->exists($path)) {
            $qr = QrCode::format('svg')->size(360)->margin(2)->generate($url);
            Storage::disk('public')->put($path, $qr);
        }

        return $path;
    }
}
