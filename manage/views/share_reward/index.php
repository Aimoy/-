<?php
/**
 * Created by PhpStorm.
 * User: ericzhou
 * Date: 18/6/19
 * Time: 17:09
 */

$coverage = explode(',', $coverage);
if ($display_type == 4) {
    $coverage = $coverage[0];
}

//echo $base64Qr;
?>

<!doctype HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta content="telephone=no" name="format-detection"/>
    <title><?= $title ?></title>
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 750 * 100 + 'px';
        console.log(document.documentElement.style.fontSize)
    </script>
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.slim.min.js"></script>
    <style>
        body, dl, dd, ul, ol, h1, h2, h3, h4, h5, h6, pre, form, input, textarea, p, hr, thead, tbody, tfoot, th, td {
            margin: 0;
            padding: 0;
        }

        ul, ol {
            list-style: none;
        }

        a {
            text-decoration: none;
        }

        html {
            -ms-text-size-adjust: none;
            -webkit-text-size-adjust: none;
            text-size-adjust: none;
            font-size: 32px;
            font-family: 'Microsoft YaHei', 'SimHei', 'SIMHEI', '微软雅黑', '黑体';
            background: #e0e0e0;
        }

        body {
            font-size: 32px;
            line-height: 1.5;
        }

        b, strong {
            font-weight: bold;
        }

        i, em {
            font-style: normal;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 5px;
        }

        table th {
            font-weight: inherit;
            border-bottom-width: 2px;
            border-bottom-color: #ccc;
        }

        img {
            border: 0 none;
            width: auto;
            max-width: 100%;
            vertical-align: top;
        }

        button, input, select, textarea {
            font-family: inherit;
            font-size: 100%;
            margin: 0;
            vertical-align: baseline;
        }

        button, html input[type="button"], input[type="reset"], input[type="submit"] {
            -webkit-appearance: button;
            cursor: pointer;
        }

        button[disabled], input[disabled] {
            cursor: default;
        }

        input[type="checkbox"], input[type="radio"] {
            box-sizing: border-box;
            padding: 0;
        }

        input[type="search"] {
            -webkit-appearance: textfield;
            -moz-box-sizing: content-box;
            -webkit-box-sizing: content-box;
            box-sizing: content-box;
        }

        input[type="search"]::-webkit-search-decoration {
            -webkit-appearance: none;
        }

        @media screen and (-webkit-min-device-pixel-ratio: 0) {
            input {
                line-height: normal !important;
            }
        }

        select[size], select[multiple], select[size][multiple] {
            border: 1px solid #AAA;
            padding: 0;
        }

        article, aside, details, figcaption, figure, footer, header, hgroup, main, nav, section, summary {
            display: block;
        }

        audio, canvas, video, progress {
            display: inline-block;
        }

        .wrap {
            width: 100%;
            height: auto;
            background: #e0e0e0;

        }

        .content {
            margin: 0.2rem 0.2rem 0 0.2rem;
            padding: 0.4rem 0.6rem 0.2rem 0.6rem;
            overflow: hidden;
            background: #fff;
            max-height: 250rem;
        }

        .tag {
            font-size: 0.24rem;
            color: #999;
            margin: 0.3rem 0 0.6rem 0;
        }

        .fr {
            float: right;
        }

        .text {
            font-size: 0.32rem;
            color: #666;
            line-height: 0.52rem;
            text-indent: 0.64rem;
        }

        h3 {
            font-size: 0.4rem;
            color: #344750;
            line-height: 0.56rem;
            font-weight: bold;
        }

        .img, .video-img {
            margin: 0.6rem auto;
            display: block;
            width: 100%;
        }

        .video-img {
            margin: 0 auto;
        }

        .video-icon {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 1.04rem;
            height: 1.04rem;
            margin: -0.52rem 0 0 -0.52rem;
        }

        .video-bg {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0.6;
            background-color: #A0A0A0;

        }

        .video-wrap {
            position: relative;
            margin-bottom: 0.6rem;
        }

        .footer {
            border-top: 0.02rem dashed #96ABB5;
            height: 3.82rem;
            position: relative;
            margin: 0rem 0.2rem;
            background: #fff;
            text-align: center;
        }

        .dot-l, .dot-r {
            width: 0.2rem;
            height: 0.44rem;
            background: #D8D9E3;
            position: absolute;
            display: block;
            top: -0.22rem;
            background: #e0e0e0;
        }

        .dot-l {
            left: 0rem;
            border-top-right-radius: 0.22rem;
            border-bottom-right-radius: 0.22rem;
        }

        .dot-r {
            right: 0rem;
            border-top-left-radius: 0.22rem;
            border-bottom-left-radius: 0.22rem;

        }

        .code {
            width: 2.8rem;
            height: 2.8rem;
            margin: 0.28rem auto 0.18rem auto;
            display: block;
        }

        .app-name {
            font-size: 0.26rem;
            color: #FD782D;
        }

        .footer-text {
            font-size: 0.26rem;
            color: #666;
        }

        .footer-content {
            position: absolute;
            bottom: 0.2rem;
            width: 100%;
            text-align: center;

        }

        #read {
            font-size: 0.26rem;
            color: #999;
            height: 1.6rem;
            line-height: 1.6rem;
            text-align: center;
            display: none;
            background: #fff;
            /* padding-bottom:0.6rem;  */
            margin: 0rem 0.2rem 0rem 0.2rem;
        }

    </style>
</head>
<body>
<div class="wrap">

    <div class="content">
        <h3><?= $title ?></h3>
        <p class="tag"><?= $source ?><span class="fr"><?= $created_at ?></span></p>

        <?php if ($display_type == 4): ?>
            <div class="video-wrap">
                <img src="<?= $coverage ?>" class="video-img"/>
                <div class="video-bg">
                </div>
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGgAAABoCAYAAAAdHLWhAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyhpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NDgzNUY2OUM1MUU5MTFFODg5QTNDQzg3MjFDMkMwMUEiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NDgzNUY2OUQ1MUU5MTFFODg5QTNDQzg3MjFDMkMwMUEiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo0ODM1RjY5QTUxRTkxMUU4ODlBM0NDODcyMUMyQzAxQSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo0ODM1RjY5QjUxRTkxMUU4ODlBM0NDODcyMUMyQzAxQSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PmTJWU4AAAoHSURBVHja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"
                     class="video-icon"/>
            </div>
        <?php else: ?>
            <div id="content">
                <?= $content_html ?>
            </div>
        <?php endif; ?>
    </div>
    <p id="read">（扫描/长按识别下方二维码查看剩余内容）</p>
    <div class="footer">
        <span class="dot-l"></span>
        <span class="dot-r"></span>
        <div class="footer-content">
            <p class="footer-text">长按小程序码 <span style="text-indent: 26rem">进入</span><span class="app-name">尚德成长+</span>阅读全文
            </p>
        </div>
    </div>
</div>
<script>
    $('p :not(img)').each(function () {
        var $this = $(this);
        var tempT = $this.text();
        var tempT = tempT.replace(/\s+/g, '');

        var temp = tempT.replace(/\s|&nbsp;/g, '');
        if (temp.length == 0 || temp == '<br>') {
            $this.remove();
        }
    });
    $('#content *').removeAttr('style');
    $('#content *').removeAttr('class');
    $('#content *').removeAttr('id');
    $('#content p').addClass('text');
    $('#content img').addClass('img');

</script>
<script>

    window.onload = function () {
        var item = document.getElementsByClassName("content")[0];
        var height = document.getElementsByClassName("content")[0].clientHeight;
        console.log(height)
        if (height > 20000) {
            item.style.height = 20000 + 'px';
            item.style.overflow = 'hidden';
            document.getElementById("read").style.display = "block";
        }
    }
</script>

</body>
</html>