<?php

namespace Itech;

use \Mpdf\Mpdf;

class PdfMaker
{
    private static $saveDirectory = '/upload/bank_receipts/';
    private static $mpdf;

    private static function makePdf(string $html, string $orientation = 'P'): void
    {
        self::$mpdf = new Mpdf([
            'orientation' => in_array($orientation, ['L', 'P']) ? $orientation : 'P',
            'mode' => 'utf-8',
            'format' => [200, 256],
        ]);
        self::$mpdf->WriteHTML($html);
    }

    public static function savePdfFile(string $html, string $orientation = 'P', string $fileName = ''): ?array
    {
        if (!$fileName) {
            $fileName = md5(rand(0, PHP_INT_MAX)) . '.pdf';
        }
        self::makePdf($html, $orientation);

        $tmpfname = tempnam(sys_get_temp_dir(), 'itech');
        $handle = fopen($tmpfname, "a+");
        $pdfContent = self::$mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
        fwrite($handle, $pdfContent);
        fclose($handle);

        $fileData = [
            "name" => $fileName,
            "size" => filesize($tmpfname),
            "tmp_name" => $tmpfname,
            "type" => "pdf",
            "MODULE_ID" => "main",
        ];

        $fid = \CFile::SaveFile($fileData, "pdfs", true);

        unlink($tmpfname);

        return $fid ? \CFile::getFileArray($fid) : null;
    }


    public static function streamPdf(string $html, string $orientation = 'P', string $fileName = '')
    {
        if (!$fileName) {
            $fileName = md5(rand(0, PHP_INT_MAX)) . '.pdf';
        }
        $fileName = self::$saveDirectory . $fileName;
        self::makePdf($html, $orientation);

        self::$mpdf->Output($fileName, \Mpdf\Output\Destination::DOWNLOAD);
    }
}