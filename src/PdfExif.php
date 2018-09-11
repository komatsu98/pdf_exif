<?php namespace komatsu98\PdfExif;

/**
 *  A sample class
 *
 *  Use this section to define what this class is doing, the PHPDocumentator will use this
 *  to automatically generate an API documentation using this information.
 *
 * @author yourname
 */
class PdfExif
{
    private $p;
    private $output = array();
    private $file;

    public function __construct($path)
    {
        $this->p = new \PDFlib();

        try {
            $this->file = $this->p->open_pdi_document(realpath($path), "");
        } catch (\Exception $e) {
            throw new \Exception('Can\'t find file');
        }
        try {
            $this->set_info_by_key();
        } catch (\Exception $e) {
            throw new \Exception('Can\'t set info');
        }
        // Open the input document
        $this->file = $this->p->open_pdi_document(realpath($path), "");

        $this->p->close_pdi_document($this->file);
    }

    public function set_info_by_key()
    {
        $count = $this->p->pcos_get_number($this->file, "length:/Info");
        for ($i = 0; $i < $count; $i++) {
            $info = "type:/Info[" . $i . "]";
            $objtype = $this->p->pcos_get_string($this->file, $info);
            $info = "/Info[" . $i . "].key";
            $key = $this->p->pcos_get_string($this->file, $info);

            if ($objtype == "name" || $objtype == "string") {
                $info = "/Info[" . $i . "]";
                $this->output[$key] = $this->p->pcos_get_string($this->file, $info);
            } else {
                $info = "type:/Info[" . $i . "]";
                $this->output[$key] = $this->p->pcos_get_string($this->file, $info);
            }
        }
    }

    public function get_all()
    {
        return $this->output;
    }

    public function get_by_key($key)
    {
        if ($key !== '') {
            return $this->output[$key];
        }
    }

}