<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\HtmlString;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'subtotal', 'total',
        'status', 'payment_method', 'payment_proof', 'paid_at',
        'notes', 'shipping_name', 'shipping_phone', 'shipping_address',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusBadgeAttribute(): HtmlString
    {
        $html = match($this->status) {
            'pending'    => '<span class="badge bg-warning text-dark">Menunggu Pembayaran</span>',
            'paid'       => '<span class="badge bg-info text-dark">Pembayaran Diterima</span>',
            'processing' => '<span class="badge bg-primary">Diproses</span>',
            'completed'  => '<span class="badge bg-success">Selesai</span>',
            'cancelled'  => '<span class="badge bg-danger">Dibatalkan</span>',
            default      => '<span class="badge bg-secondary">Unknown</span>',
        };
        return new HtmlString($html);
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            'qris'          => 'QRIS',
            'dana'          => 'DANA',
            'gopay'         => 'GoPay',
            'ovo'           => 'OVO',
            'shopeepay'     => 'ShopeePay',
            'transfer_bank' => 'Transfer Bank',
            default         => '-',
        };
    }

    public static function generateOrderNumber(): string
    {
        return 'LSC-' . strtoupper(uniqid()) . '-' . date('Ymd');
    }
}
