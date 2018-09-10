<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/09/10
 * Time: 14:19
 */

namespace App\Models;


class SitemapUrlModel extends ModelBase
{
    public $timestamps = false;
    protected $primaryKey = 'url_id';
    protected $table = 'sitemap_url';

    public function insertSitemap(string $condition, array $bindArray)
    {
        $pdo = self::getPdo();
        $sql = "INSERT INTO sitemap_url (url, creator_id) " . $condition;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($bindArray);
    }

}
