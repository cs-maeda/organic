<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/09/12
 * Time: 8:46
 */

namespace App\Helper;


class XmlSitemapHelper
{
    protected $filePath = '';
    protected $changeFreq = '';
    protected $handle = null;

    public function __construct(string $filePath, $changeFreq = 'daily')
    {
        $this->filePath = $filePath;
        $this->changeFreq = $changeFreq;
        $this->handle = fopen($this->filePath, 'w');
    }

    /**
     * @throws \Exception
     */
    public function __destruct()
    {
        $res = fclose($this->handle);
        if ($res === false){
            throw new \Exception('XML file close error occurred.');
        }
    }

    /**
     * @throws \Exception
     */
    public function writeHeader()
    {
        $header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        $res = fputs($this->handle, $header);
        if ($res === false){
            throw new \Exception('XML file write header error occurred.');
        }
    }

    /**
     * @param string $url
     * @throws \Exception
     */
    public function writeContents(string $url)
    {
        $contentsFormat = " <url>\n  <loc>%s</loc>\n  <lastmod>%s</lastmod>\n  <changefreq>%s</changefreq>\n  <priority>1.0</priority>\n </url>\n";

        $ymd = date('Y-m-d');
        $contents = sprintf($contentsFormat, $url, $ymd, $this->changeFreq);
        $res = fputs($this->handle, $contents);
        if ($res === false) {
            throw new \Exception('XML file write contents error occurred.');
        }
    }

    /**
     * @throws \Exception
     */
    public function writeFooter()
    {
        $footer = "</urlset>\n";
        $res = fputs($this->handle, $footer);
        if ($res === false) {
            throw new \Exception('XML file write footer error occurred.');
        }
    }
}
