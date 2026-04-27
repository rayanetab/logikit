<?php

namespace App\Service;

use App\Entity\Assignment;
use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;

class PdfService
{
    public function __construct(
        private Environment $twig
    ) {}

    public function generateDecharge(Assignment $assignment): string
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = $this->twig->render('pdf/decharge.html.twig', [
            'assignment' => $assignment,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}