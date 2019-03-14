<?php

/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 18/5/4
 * Time: 15:35
 */

namespace manage\library;


class HtmlContent
{

    /**
     * 从正文中截取文章摘要
     * @param $contentHmtl
     * @param int $length
     * @return string
     */
    static function getDescriptionFrom($contentHmtl, $length = 50)
    {
        $cleaned = self::removeTagsAndWhiteSpace($contentHmtl);
        //$cleaned =  trim($cleaned);
        return mb_substr($cleaned, 0, $length);
    }

    /**
     * 去掉连续空白字符串
     * @param $html
     * @return mixed
     */
    static function removeTagsAndWhiteSpace($html)
    {
        $temp = strip_tags($html);
        //https://stackoverflow.com/questions/2326125/remove-multiple-whitespaces
        return preg_replace('/\s{2,}/mu', ' ', $temp);
    }


    /**
     * 提取正文图片src到尚德oss,同时提换src地址
     * @param string $content
     * @return string
     */
    static function saveContentImageToSunlandsOssAndReplaceContentSrc(string $content): string
    {
        if (empty($content)) {
            return '<p></p>';
        }
        //https://stackoverflow.com/questions/47273306/how-to-get-all-existing-images-src-in-this-url-with-php
        //耗时操作,很容易出错
        set_time_limit(360);

        $doc = new \DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML($content);
        libxml_clear_errors();
        /** @var Oss $oss */
        $oss = \Yii::$app->oss;
        foreach ($doc->getElementsByTagName('img') as $nodeImage) {
            /** @var \DOMElement $nodeImage */
            $imageUrl = trim($nodeImage->getAttribute('src'));
            $ossUrl = $oss->fetchImageSrcToOss($imageUrl);
            if (!empty($ossUrl)) {
                $content = str_ireplace($imageUrl, $ossUrl, $content);
            }
        }

        return $content;
    }


    /**
     * 提出文章正文中的image src
     * @param string $content
     * @return array
     */
    static function extractImageFromContent(string $content):array {
        if (empty($content)) {
            return [];
        }
        $doc = new \DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML($content);
        libxml_clear_errors();
        $srcArr = [];
        foreach ($doc->getElementsByTagName('img') as $nodeImage) {
            /** @var \DOMElement $nodeImage */
            $imageSrc = trim($nodeImage->getAttribute('src'));
            if (!empty($imageSrc)) {
                $srcArr[] = $imageSrc;
            }
        }
        return $srcArr;
    }

    /**
     * 正则移除image
     * @param string $content
     * @return mixed
     */
    static function removeStyleFromImage(string $content)
    {
        return preg_replace('/(\<img[^>]+)(style\=\"[^\"]+\")([^>]*)(>)/', '${1}${3}${4}', $content);
    }


    /**
     * 图片替换成中继服务器图片
     * @param string $content
     * @return string
     */
    static function changeImageSrcToMiddleManServer(string $content): string
    {
        $content = str_ireplace('data-src', 'src', $content);
        $middleManApi = \Yii::$app->params['imageMiddleManApi'];
        $replace = $middleManApi . 'http://mmbiz.qpic.cn';
        $content = str_ireplace('https://mmbiz.qpic.cn', $replace, $content);
        return $content;
    }

    /**
     * 文章保存之前提换图片中间人地址
     * @param string $content
     * @return string
     */
    static function removeImageMiddleManHost(string $content): string
    {
        $middleManApi = \Yii::$app->params['imageMiddleManApi'];
        return str_ireplace($middleManApi, '', $content);
    }


    /**
     * 转换coverage字段图片地址,到oss 以逗号分隔URIs
     * @param string $coverage
     * @return string 以逗号分隔URIs
     */
    static function convertCoverageToOss(string $coverage): string
    {

        if ($coverage === '') {
            return '';
        }
        $coverageArr = explode(',', $coverage);

        /** @var Oss $oss */
        $oss = \Yii::$app->oss;
        /** @var string $ossImageHost example: https://bucket.ali.oss.com */
        $ossImageHost = $oss->imageHost;

        $coverageURIs = [];
        foreach ($coverageArr as $url) {
            if (stripos($url, $ossImageHost) === false) {
                $url = $oss->fetchImageSrcToOss($url);
            }
            if ($url !== '') {
                $coverageURIs[] = str_ireplace("$ossImageHost/", '', $url);
            }
        }
        return implode(',', $coverageURIs);
    }

}


