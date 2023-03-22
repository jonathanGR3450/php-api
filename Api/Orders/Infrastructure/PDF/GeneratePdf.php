<?php

declare(strict_types=1);

namespace Api\Orders\Infrastructure\PDF;

require_once('./vendor/TCPDF/tcpdf.php');

use Api\Customers\Domain\Aggregate\Customer;
use Api\Orders\Domain\Aggregate\Order;
use TCPDF;

class GeneratePdf
{
    private Order $order;
    private array $orderDetail;
    private array $products;
    private Customer $customer;
    private TCPDF $pdf;
    private array $paymets;

    private function __construct(Order $order, array $orderDetail, Customer $customer, array $products, array $paymets, TCPDF $pdf)
    {
        $this->order = $order;
        $this->orderDetail = $orderDetail;
        $this->customer = $customer;
        $this->pdf = $pdf;
        $this->products = $products;
        $this->paymets = $paymets;
    }

    public static function create(Order $order, array $orderDetail, Customer $customer, array $products, array $paymets): self
    {
        return new static($order, $orderDetail, $customer, $products, $paymets, new TCPDF());
    }

    public function generatePdf()
    {
        $this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor($this->customer->customerName()->value());
        $this->pdf->SetTitle("Order number " . $this->order->orderNumber()->value());
        $this->pdf->SetSubject("Order number " . $this->order->orderNumber()->value());

        // Establecer las opciones de visualización del documento
        $this->pdf->SetHeaderData('', 0, '', '');
        $this->pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
        $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $this->pdf->SetMargins(15, 15, 15);
        $this->pdf->SetAutoPageBreak(TRUE, 15);
        $this->pdf->SetFont('helvetica', '', 12);
        $this->pdf->AddPage();
        $html = file_get_contents(PROJECT_ROOT_PATH . "/Orders/Infrastructure/PDF/views/pdf.html");

        $image_file = PROJECT_ROOT_PATH . "/Orders/Infrastructure/PDF/statics/img/logoEmpresa.jpg";
        $this->pdf->Image($image_file, 10, 15, 50, 0, 'JPG');

        // crear tabla html
        $table = '';
        $totalFinal = 0;
        foreach ($this->orderDetail as $key => $detail) {
            $product = $this->products[$key]; // busco el producto relacionado con ese detalle orden 
            $total = $detail->priceEach()->value() * $detail->quantityOrdered()->value();
            $totalFinal += $total;
            $table .= '<tr>
                        <td style="border: 1px solid #000000; padding: 5px;">' . $product->productName()->value() . '</td>
                        <td style="border: 1px solid #000000; padding: 5px;">' . $product->productLine()->value() . '</td>
                        <td style="border: 1px solid #000000; padding: 5px;">' . $detail->priceEach()->value() . '</td>
                        <td style="border: 1px solid #000000; padding: 5px;">' . $detail->quantityOrdered()->value() . '</td>
                        <td style="border: 1px solid #000000; padding: 5px;">' . $total . '</td>
                    </tr>';
        }
        $totalFinal =round($totalFinal, 2);

        // valor pagado vs valor que debe
        $pagado = array_reduce($this->paymets, function($acumulador, $payment) {
            return $acumulador + $payment->amount()->value() ?? 0;
        });
        $pagado = round($pagado ?? 0, 2);

        $debe = $totalFinal - $pagado;
        $debe = round($debe, 2);

        // change variables in template
        $html = str_replace('{tablaDetail}', $table, $html);
        $html = str_replace('{totalFinal}', (string) $totalFinal, $html);

        $html = str_replace('{orderNumber}', (string) $this->order->orderNumber()->value(), $html);
        $html = str_replace('{orderDate}', (string) $this->order->orderDate()->value(), $html);
        $html = str_replace('{customerName}', (string) $this->customer->customerName()->value(), $html);
        $html = str_replace('{customerNumber}', (string) $this->customer->customerNumber()->value(), $html);
        $html = str_replace('{shippedDate}', (string) $this->order->shippedDate()->value(), $html);
        $html = str_replace('{requiredDate}', (string) $this->order->requiredDate()->value(), $html);
        $html = str_replace('{status}', (string) $this->order->status()->value(), $html);
        $html = str_replace('{paid}', (string) $pagado, $html);
        $html = str_replace('{owe}', (string) $debe, $html);
        $this->pdf->writeHTML($html, true, false, true, false, '');

    }

    public function getPdf(): string
    {
        return $this->pdf->Output('', 'S');
    }

}
