<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendOrderStatusUpdateToHub implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order->withoutRelations(); // Hindari serialisasi relasi
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $hubApiUrl = env('HUB_API_URL') . '/update-order-status'; // URL API hub
        $hubApiKey = env('HUB_API_KEY'); // API Key untuk autentikasi

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $hubApiKey, // Contoh autentikasi
                'Content-Type' => 'application/json',
            ])->post($hubApiUrl, [
                'hub_order_id' => $this->order->hub_order_id,
                'current_status' => $this->order->status,
                'tracking_number' => $this->order->tracking_number ?? null, // Asumsi ada kolom tracking_number
                'updated_at' => $this->order->updated_at->toDateTimeString(),
            ]);

            if ($response->successful()) {
                Log::info("Order status update sent to hub successfully for order: {$this->order->id}");
            } else {
                Log::error("Failed to send order status update to hub for order: {$this->order->id}. Response: " . $response->body());
                // Anda bisa melempar exception di sini untuk retry
                throw new \Exception("Hub API returned non-success status: " . $response->status());
            }
        } catch (\Exception $e) {
            Log::error("Error sending order status update to hub for order: {$this->order->id}. Error: " . $e->getMessage());
            // Ini akan menyebabkan job di-retry berdasarkan konfigurasi retry Anda
            $this->fail($e);
        }
    }
}