<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/09/10
 * Time: 16:03
 */

namespace App\Helper;


use Illuminate\Http\Request;
use App\Models\SitemapUrlModel;

abstract class SitemapBaseHelper
{
    protected $creatorId = null;
    protected $host = null;

    public function __construct(Request $request, int $creatorId)
    {
        $this->creatorId = $creatorId;
        $this->host = $request->root();
    }

    public function clear()
    {
        SitemapUrlModel::where('creator_id', $this->creatorId)->delete();
    }

    public function top()
    {
        $model = new SitemapUrlModel();
        $model->insertSitemap("SELECT ? AS url, ? AS creator_id", [$this->host, $this->creatorId]);
    }

    public function prefecture()
    {
        $model = new SitemapUrlModel();
        $condition =
            "SELECT " .
                "CONCAT(?, '/', mst_prefecture.prefecture_alphabet, '/') AS url, " .
                "? AS creator_id " .
            "FROM `mst_prefecture`";

        $model->insertSitemap($condition, [$this->host, $this->creatorId]);
    }

    abstract public function city();
    abstract public function town();
    abstract public function station();
}
