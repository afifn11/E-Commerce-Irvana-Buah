<?php
namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $statusLabel;
    public string $statusColor;
    public string $statusMessage;

    public function __construct(public Order $order)
    {
        $map = [
            'pending'    => ['label' => 'Menunggu Konfirmasi', 'color' => '#d97706', 'msg' => 'Pesanan Anda telah diterima dan sedang menunggu konfirmasi dari tim kami.'],
            'processing' => ['label' => 'Sedang Diproses',    'color' => '#0891b2', 'msg' => 'Kabar baik! Pesanan Anda sedang kami siapkan dengan penuh semangat.'],
            'shipped'    => ['label' => 'Sedang Dikirim',     'color' => '#7c3aed', 'msg' => 'Pesanan Anda sudah dalam perjalanan. Mohon tunggu di lokasi pengiriman.'],
            'delivered'  => ['label' => 'Selesai',            'color' => '#059669', 'msg' => 'Pesanan Anda telah sampai! Jangan lupa beri ulasan untuk produk yang Anda beli.'],
            'cancelled'  => ['label' => 'Dibatalkan',         'color' => '#dc2626', 'msg' => 'Pesanan Anda telah dibatalkan. Hubungi kami jika ada pertanyaan.'],
        ];
        $statusVal = $order->status instanceof \BackedEnum ? $order->status->value : (string) $order->status;
        $info = $map[$statusVal] ?? ['label' => ucfirst($statusVal), 'color' => '#64748b', 'msg' => 'Status pesanan Anda telah diperbarui.'];
        $this->statusLabel   = $info['label'];
        $this->statusColor   = $info['color'];
        $this->statusMessage = $info['msg'];
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: "Update Pesanan #{$this->order->order_number} — {$this->statusLabel}");
    }

    public function content(): Content
    {
        return new Content(view: 'emails.order-status');
    }
}
