<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckoutMail extends Mailable
{
    use Queueable, SerializesModels;

    public $orders;
    public $total;
    public $shipping;
    public $grandTotal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->orders = $data['order'];
        $this->total = $data['subtotal'];
        $this->shipping = $data['shipping'];
        $this->grandTotal = $data['grandTotal'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->to('gumilang.dev@gmail.com')
            ->subject('Order is on Process (Invoice: #123123123213')->markdown(
                'emailku'
            );
    }
}
