<?php
/**
 * Created by PhpStorm.
 * User: maeda
 * Date: 2018/08/02
 * Time: 16:49
 */

namespace App\Value;


class EachLinkValue
{
    protected $caption = null;
    protected $link = null;

    public function __construct(string $caption, string $link)
    {
        $this->caption = $caption;
        $this->link = $link;
    }

    public function caption(): string
    {
        return $this->caption;
    }

    public function link(): string
    {
        return $this->link;
    }
}
