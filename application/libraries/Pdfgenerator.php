<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('DOMPDF_ENABLE_AUTOLOAD', false);
require_once("./vendor/dompdf/dompdf/dompdf_config.inc.php");

class Pdfgenerator {

  public function generate($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
  {
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf", array("Attachment" => 0));
    } else {
        return $dompdf->output();
    }
  }

  // PDF GENERATE VIEW ON BROWSER
  public function generate_view_default($html, $filename, $stream, $paper, $orientation)
  {
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf", array("Attachment" => 0));
    } else {
        return $dompdf->output();
    }
  }

  // PDF GENERATE VIEW ON BROWSER WITH PAGE NUMBER
  public function generate_view_with_page_number($html, $filename, $stream, $paper, $orientation, $page_horizontal, $page_vertical)
  {
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper($paper, $orientation);
    $dompdf->render();

    $canvas = $dompdf->get_canvas(); 
	$font = Font_Metrics::get_font("tahoma"); 
	$canvas->page_text($page_horizontal, $page_vertical, "Hal : {PAGE_NUM} dari {PAGE_COUNT}", $font, 9, array(0,0,0));

    if ($stream) {
        $dompdf->stream($filename.".pdf", array("Attachment" => 0));
    } else {
        return $dompdf->output();
    }
  }

  // PDF GENERATE VIEW ON BROWSER WITH PAGE NUMBER ONLY
  public function generate_view_with_page_number_only($html, $filename, $stream, $paper, $orientation, $page_horizontal, $page_vertical)
  {
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper($paper, $orientation);
    $dompdf->render();

    $canvas = $dompdf->get_canvas(); 
	$font = Font_Metrics::get_font("tahoma"); 
	$canvas->page_text($page_horizontal, $page_vertical, "{PAGE_NUM} dari {PAGE_COUNT}", $font, 9, array(0,0,0));

    if ($stream) {
        $dompdf->stream($filename.".pdf", array("Attachment" => 0));
    } else {
        return $dompdf->output();
    }
  }

  // PDF GENERATE DIRECT DOWNLOAD
  public function generate_download_default($html, $filename, $stream, $paper, $orientation)
  {
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
  }

  // PDF GENERATE DIRECT DOWNLOAD WITH PAGE NUMBER
  public function generate_download_with_page_number($html, $filename, $stream, $paper, $orientation, $page_horizontal, $page_vertical)
  {
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper($paper, $orientation);
    $dompdf->render();

    $canvas = $dompdf->get_canvas(); 
	$font = Font_Metrics::get_font("tahoma"); 
	$canvas->page_text($page_horizontal, $page_vertical, "Hal : {PAGE_NUM} dari {PAGE_COUNT}", $font, 9, array(0,0,0));

    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
  }

  // PDF GENERATE DIRECT DOWNLOAD WITH PAGE NUMBER ONLY
  public function generate_download_with_page_number_only($html, $filename, $stream, $paper, $orientation, $page_horizontal, $page_vertical)
  {
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper($paper, $orientation);
    $dompdf->render();

    $canvas = $dompdf->get_canvas(); 
	$font = Font_Metrics::get_font("tahoma"); 
	$canvas->page_text($page_horizontal, $page_vertical, "{PAGE_NUM} dari {PAGE_COUNT}", $font, 9, array(0,0,0));

    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
  }
}