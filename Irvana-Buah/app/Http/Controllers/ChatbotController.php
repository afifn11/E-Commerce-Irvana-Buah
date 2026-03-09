<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function message(Request $request): JsonResponse
    {
        $request->validate(['message' => 'required|string|max:500']);
        $userMessage = trim($request->input('message'));

        if ($this->isHealthQuery($userMessage)) {
            return $this->handleHealthQuery($userMessage);
        }

        return response()->json(['type' => 'faq']);
    }

    protected function isHealthQuery(string $message): bool
    {
        $keywords = [
            'kesehatan','sehat','sakit','kulit','jerawat','diet','langsing',
            'vitamin','imun','daya tahan','kolesterol','diabetes','gula darah',
            'tekanan darah','jantung','pencernaan','sembelit','anemia','hamil',
            'ibu hamil','anak','bayi','mata','rambut','tulang','sendi',
            'lelah','lemas','energi','stamina','cocok untuk','baik untuk',
            'bagus untuk','buah apa','rekomendasi buah','buah yang','analisis',
            'manfaat','khasiat','nutrisi','gizi','antioksidan','demam','flu',
        ];
        $lower = strtolower($message);
        foreach ($keywords as $k) {
            if (str_contains($lower, $k)) return true;
        }
        return false;
    }

    protected function handleHealthQuery(string $userMessage): JsonResponse
    {
        $apiKey = config('services.anthropic.key');

        if (empty($apiKey)) {
            Log::error('Chatbot: ANTHROPIC_API_KEY tidak ditemukan di .env');
            return $this->fallbackResponse('API key tidak dikonfigurasi.');
        }

        $products = Product::with('category')->active()->inStock()->get()
            ->map(fn($p) => [
                'name'       => $p->name,
                'category'   => $p->category?->name ?? '',
                'slug'       => $p->slug,
                'price'      => 'Rp ' . number_format((float)$p->price, 0, ',', '.'),
                'detail_url' => route('product.detail', $p->slug),
                'image_url'  => $p->image_url,
            ])->values()->toArray();

        $productList = collect($products)
            ->map(fn($p) => "- {$p['name']} ({$p['category']}) — {$p['price']}")
            ->join("\n");

        $systemPrompt = <<<PROMPT
Kamu adalah asisten kesehatan dan nutrisi buah untuk toko buah online "Irvana Buah".
Tugasmu: memberikan rekomendasi buah yang tepat berdasarkan kondisi kesehatan atau kebutuhan pengguna, HANYA dari daftar produk yang tersedia di toko.

Daftar produk tersedia:
{$productList}

Instruksi penting:
1. Jawab dalam Bahasa Indonesia yang ramah dan natural.
2. Jelaskan secara singkat MENGAPA buah tersebut bermanfaat (kandungan nutrisinya).
3. Rekomendasikan 2-4 buah yang PALING relevan dari daftar produk di atas.
4. Untuk setiap rekomendasi, sebutkan nama buah persis seperti di daftar produk.
5. Di akhir jawaban, tuliskan tag khusus ini PERSIS seperti formatnya:
   [PRODUK_REKOMENDASI: nama_buah_1, nama_buah_2, nama_buah_3]
6. Jika tidak ada produk yang relevan, tulis [PRODUK_REKOMENDASI: tidak_ada]
7. Jawaban maksimal 200 kata, padat dan informatif.
PROMPT;

        try {
            $response = Http::withHeaders([
                'x-api-key'         => $apiKey,
                'anthropic-version' => '2023-06-01',
                'Content-Type'      => 'application/json',
            ])->timeout(25)->post('https://api.anthropic.com/v1/messages', [
                'model'      => 'claude-haiku-4-5-20251001',
                'max_tokens' => 600,
                'system'     => $systemPrompt,
                'messages'   => [['role' => 'user', 'content' => $userMessage]],
            ]);

            if (!$response->successful()) {
                Log::error('Chatbot API error', ['status' => $response->status(), 'body' => $response->body()]);
                return $this->fallbackResponse();
            }

            $aiText = $response->json('content.0.text', '');

            $recommendedProducts = [];
            if (preg_match('/\[PRODUK_REKOMENDASI:\s*(.+?)\]/', $aiText, $matches)) {
                $names = array_map('trim', explode(',', $matches[1]));
                if ($names[0] !== 'tidak_ada') {
                    foreach ($names as $name) {
                        $matched = collect($products)->first(fn($p) =>
                            stripos($p['name'], $name) !== false || stripos($name, $p['name']) !== false
                        );
                        if ($matched) $recommendedProducts[] = $matched;
                    }
                }
            }

            $cleanText = trim(preg_replace('/\[PRODUK_REKOMENDASI:.*?\]/', '', $aiText));

            return response()->json([
                'type'     => 'health',
                'answer'   => $cleanText,
                'products' => array_values(array_unique($recommendedProducts, SORT_REGULAR)),
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot exception: ' . $e->getMessage());
            return $this->fallbackResponse();
        }
    }

    protected function fallbackResponse(string $reason = ''): JsonResponse
    {
        return response()->json([
            'type'     => 'health',
            'answer'   => 'Maaf, saya sedang tidak bisa menganalisis saat ini. Silakan coba lagi dalam beberapa saat, atau hubungi kami via WhatsApp untuk konsultasi langsung! 🍊',
            'products' => [],
        ]);
    }
}