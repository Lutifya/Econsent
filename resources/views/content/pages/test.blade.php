<?php

function getImageFromUrl($url){
    // Verifica se il file è presente nella cache
    $cacheFile = 'cache/' . md5($url) . '_image.html';

    if (file_exists($cacheFile) && filemtime($cacheFile) > (time() - 3600)) {
        // Se il file è presente nella cache e non è scaduto, utilizza la cache
        return file_get_contents($cacheFile);
    } else {
        // Altrimenti, effettua la richiesta HTTP e memorizza nella cache solo l'immagine
        $html = file_get_contents($url);

        $dom = new DOMDocument;
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);
        $divClass = 'single__featured-image';
        $divs = $xpath->query("//*[contains(@class, '$divClass')]");

        if ($divs->length > 0) {
            $imgElement = $divs->item(0)->getElementsByTagName('img')->item(0);

            if ($imgElement) {
                $srcset = $imgElement->getAttribute('srcset');
                $srcsetParts = explode(' ', $srcset);
                $imageContent = $srcsetParts[0];
                file_put_contents($cacheFile, $imageContent);
                return $imageContent;
            }
        }
    }

    return "";
}

function getTitleFromUrl($url)
{
    // Verifica se il file di cache esiste ed è valido
    $cacheFile = 'cache/' . md5($url) . '_title.html';

    if (file_exists($cacheFile) && filemtime($cacheFile) > (time() - 3600)) {
        // Se il file di cache è valido, leggi direttamente da esso
        return file_get_contents($cacheFile);
    } else {
        // Altrimenti, effettua la richiesta HTTP
        $html = file_get_contents($url);

        // Verifica se il contenuto è stato ottenuto con successo
        if ($html !== false) {
            $dom = new DOMDocument;
            @$dom->loadHTML($html);
            $xpath = new DOMXPath($dom);
            $divClass = 'single__title';
            $divs = $xpath->query("//*[contains(@class, '$divClass')]");

            if ($divs->length > 0) {
                $titleElement = $divs->item(0)->getElementsByTagName('h1')->item(0);

                if ($titleElement) {
                    $titleContent = $titleElement->textContent;
                    file_put_contents($cacheFile, $titleContent);
                    return $titleContent;
                }
            }
        }
    }

    return ""; // Restituisce una stringa vuota se il titolo non può essere ottenuto
}


function getDescriptionFromUrl($url)
{
    // Verifica se il file di cache esiste ed è valido
    $cacheFile = 'cache/' . md5($url) . '_description.html';

    if (file_exists($cacheFile) && filemtime($cacheFile) > (time() - 3600)) {
        // Se il file di cache è valido, leggi direttamente da esso
        return file_get_contents($cacheFile);
    } else {
        // Altrimenti, effettua la richiesta HTTP
        $html = file_get_contents($url);

        // Verifica se il contenuto è stato ottenuto con successo
        if ($html !== false) {
            $dom = new DOMDocument;
            @$dom->loadHTML($html);
            $xpath = new DOMXPath($dom);
            $divClass = 'post__description';
            $divs = $xpath->query("//*[contains(@class, '$divClass')]");

            if ($divs->length > 0) {
                $descriptionElement = $divs->item(0)->getElementsByTagName('p')->item(0);

                if ($descriptionElement) {
                    $descriptionContent = $descriptionElement->textContent;
                    file_put_contents($cacheFile, $descriptionContent);
                    return $descriptionContent;
                }
            }
        }
    }

    return ""; // Restituisce una stringa vuota se la descrizione non può essere ottenuta
}


function readXmlFromUrlAndReturnHtml($url)
{
    // Verifica se il file è presente nella cache
    $cacheFile = 'cache/' . md5($url) . '_xml.html';

    if (file_exists($cacheFile) && filemtime($cacheFile) > (time() - 3600)) {
        // Se il file è presente nella cache e non è scaduto, utilizza la cache
        return file_get_contents($cacheFile);
    } else {
        // Altrimenti, effettua la richiesta HTTP e memorizza nella cache
        $xml = file_get_contents($url);

        $feed = simplexml_load_string($xml);

        if ($feed) {
            $items = $feed->channel->item;
            $itemCount = count($items);

            $itemCount = min($itemCount, 6);
            $container = "";
            $html = '<div class="featured-bottom container section-3-columns" bis_skin_checked="1">';
            $html2 = '<div class="featured-bottom container section-3-columns" bis_skin_checked="1">';
            for ($i = 0; $i < $itemCount; $i++) {
                $item = $items[$i];
                $title = $item->title;
                $description = $item->description;
                $link = $item->link;

                $urlImage = getImageFromUrl($link);

                $div = '<div class="col-4" bis_skin_checked="1">
                    <article class="partial-card-post-big--k2 ">
                        <link rel="stylesheet"
                            href="https://www.lifegate.it/app/themes/lifegate-2020/dist/css/components/partials/partial-card-post-big--k2.min.css"
                            media="all" onload="this.media=\'all\'">
                        <div class="card__thumbnail--big" bis_skin_checked="1">
                            <picture data-link=""
                                style="background: none;">
                                <img class="img-article lazyloaded"
                                    data-srcset="' . $urlImage . '"
                                    alt="' . $title . '"
                                    srcset="' . $urlImage . '">
                            </picture>
                        </div>
                        <div class="card__main-container" bis_skin_checked="1">
                            <div class="card__title" bis_skin_checked="1">
                                <a href="' . $link . '" target="_blank">
                                    <h3>' . $title . '</h3>
                                </a>
                            </div>
                            <div class="card__content" bis_skin_checked="1">
                                <p class="abstract">' . $description . '</p>
                            </div>
                        </div>
                    </article>
                </div>';

                if (($i + 1) % 3 == 0) {
                    $html2 = $html2 . $div . "</div>";
                    $container = $container . $html2;
                    $html2 = $html;
                } else {
                    $html2 = $html2 . $div;
                }
            }

            file_put_contents($cacheFile, $container);
            return $container;
        }
    }
}

$transizioneClimatica = [
    [
        "link"=> "https://www.lifegate.it/rendicontazione-sostenibilita-imprese"
    ],
    [
        "link"=> "https://www.lifegate.it/green-deal-industrial-plan-dettaglio"
    ],
    [
        "link"=> "https://www.lifegate.it/just-transition-transizione-ecologica-dovra-essere-anche-giusta"
    ],
    [
        "link"=> "https://www.lifegate.it/mitigazione-adattamento-cambiamenti-climatici"
    ],
    [
        "link"=> "https://www.lifegate.it/carbon-neutrality-net-zero"
    ],
    [
        "link"=> "https://www.lifegate.it/concentrazione-co2-spiegazione-record-clima"
    ],
    [
        "link"=> "https://www.lifegate.it/cambiamenti-climatici-cause-conseguenze "
    ],
    [
        "link"=> "https://www.lifegate.it/europa-piani-adattamento"
    ],
    [
        "link"=> "https://www.lifegate.it/come-contrastare-gli-effetti-dei-cambiamenti-climatici"
    ],
    [
        "link"=> "https://www.lifegate.it/decarbonizzazione-tecnologie"
    ],

];

$bestPratices = [
    [
        "link"=>"https://www.lifegate.it/attivismo-civico-osservatorio-civic-brand"
    ],
    [
        "link"=>"https://www.lifegate.it/green-impact-initiative-2023"
    ], 
    [
        "link"=>"https://www.lifegate.it/henkel-energie-rinnovabili"
    ],
    [
        "link"=>"https://www.lifegate.it/ridurre-le-emissioni-e-la-plastica-questo-limpegno-di-snam-per-il-futuro"
    ],
    [
        "link"=>"https://www.lifegate.it/ohop-ingka-ikea-figueres"
    ],
    [
        "link"=>"https://www.lifegate.it/servizi-tecnologie-digitali-transizione-energetica"
    ],
    [
        "link"=>"https://www.lifegate.it/sostenibilita-economica-ambientale-sociale-bosch"
    ],
    [
        "link"=>"https://www.lifegate.it/hsbc-finanziamenti-gas-petrolio"
    ],
    [
        "link"=>"https://www.lifegate.it/guerino-delfino-lifegate-way"
    ],

];
function readArticleFromInformationList($items){
        $itemCount = count($items);
        
        $container = "";
        $html = '<div class="featured-bottom container section-3-columns" bis_skin_checked="1">';
        $html2 = '<div class="featured-bottom container section-3-columns" bis_skin_checked="1">';
        for ($i = 0; $i < $itemCount; $i++) {
            $item = $items[$i];
            $link = $item["link"];

            $title = getTitleFromUrl($link);
            $description = getDescriptionFromUrl($link);
            $urlImage = getImageFromUrl($link);

            $div= '<div class="col-4" bis_skin_checked="1">
                <article class="partial-card-post-big--k2 ">
                    <link rel="stylesheet"
                        href="https://www.lifegate.it/app/themes/lifegate-2020/dist/css/components/partials/partial-card-post-big--k2.min.css"
                        media="all" onload="this.media=\'all\'">
                    <div class="card__thumbnail--big" bis_skin_checked="1">
                        <picture data-link=""
                            style="background: none;">
                            <img class="img-article lazyloaded"
                                data-srcset="'.$urlImage.'"
                                alt="'.$title.'"
                                srcset="'.$urlImage.'">
                        </picture>
                    </div>
                    <div class="card__main-container" bis_skin_checked="1">
                        <div class="card__title" bis_skin_checked="1">
                            <a href="'.$link.'" target="_blank">
                                <h3>'.$title.'</h3>
                            </a>
                        </div>
                        <div class="card__content" bis_skin_checked="1">
                            <p class="abstract">'.$description.'</p>
                        </div>
                    
                    </div>
                </article>
                </div>
            ';

            if(($i+1) % 3 == 0){
                $html2 = $html2 . $div ."</div>";
                $container = $container . $html2;
                $html2 = $html;
            }
            else{
                $html2 = $html2 . $div;
            }
        
        }

        return $container;
 
}

?>
<!doctype html>
<html lang="it-IT" class="no-js">

<head>
    <script type="text/javascript">
    if (!gform) {
        document.addEventListener("gform_main_scripts_loaded", function() {
            gform.scriptsLoaded = !0
        }), window.addEventListener("DOMContentLoaded", function() {
            gform.domLoaded = !0
        });
        var gform = {
            domLoaded: !1,
            scriptsLoaded: !1,
            initializeOnLoaded: function(o) {
                gform.domLoaded && gform.scriptsLoaded ? o() : !gform.domLoaded && gform.scriptsLoaded ? window
                    .addEventListener("DOMContentLoaded", o) : document.addEventListener(
                        "gform_main_scripts_loaded", o)
            },
            hooks: {
                action: {},
                filter: {}
            },
            addAction: function(o, n, r, t) {
                gform.addHook("action", o, n, r, t)
            },
            addFilter: function(o, n, r, t) {
                gform.addHook("filter", o, n, r, t)
            },
            doAction: function(o) {
                gform.doHook("action", o, arguments)
            },
            applyFilters: function(o) {
                return gform.doHook("filter", o, arguments)
            },
            removeAction: function(o, n) {
                gform.removeHook("action", o, n)
            },
            removeFilter: function(o, n, r) {
                gform.removeHook("filter", o, n, r)
            },
            addHook: function(o, n, r, t, i) {
                null == gform.hooks[o][n] && (gform.hooks[o][n] = []);
                var e = gform.hooks[o][n];
                null == i && (i = n + "_" + e.length), null == t && (t = 10), gform.hooks[o][n].push({
                    tag: i,
                    callable: r,
                    priority: t
                })
            },
            doHook: function(o, n, r) {
                if (r = Array.prototype.slice.call(r, 1), null != gform.hooks[o][n]) {
                    var t, i = gform.hooks[o][n];
                    i.sort(function(o, n) {
                        return o.priority - n.priority
                    });
                    for (var e = 0; e < i.length; e++) "function" != typeof(t = i[e].callable) && (t = window[
                        t]), "action" == o ? t.apply(null, r) : r[0] = t.apply(null, r)
                }
                if ("filter" == o) return r[0]
            },
            removeHook: function(o, n, r, t) {
                if (null != gform.hooks[o][n])
                    for (var i = gform.hooks[o][n], e = i.length - 1; 0 <= e; e--) null != t && t != i[e].tag ||
                        null != r && r != i[e].priority || i.splice(e, 1)
            }
        }
    }
    </script>

    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"
        media="only screen and (min-width: 960px)">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, maximum-scale=5, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <style>
    @font-face {
        font-family: 'Nunito';
        src: local("Nunito-regular"), url(/fonts/Nunito-Regular.woff) format("woff");
        font-display: swap;
        font-weight: 400;
        font-style: normal
    }

    @font-face {
        font-family: 'Nunito';
        src: local("Nunito-semibold"), url(/fonts/Nunito-SemiBold.woff) format("woff");
        font-display: swap;
        font-weight: 600;
        font-style: normal
    }

    @font-face {
        font-family: 'Nunito';
        src: local("Nunito-bold"), local("Nunito Bold"), url(/fonts/Nunito-Bold.woff) format("woff");
        font-display: swap;
        font-weight: 800;
        font-style: normal
    }

    @font-face {
        font-family: 'CrimsonPro';
        src: url(/fonts/CrimsonPro-Regular.woff) format("woff");
        font-weight: 400;
        font-display: swap;
        font-style: normal
    }

    @font-face {
        font-family: 'CrimsonPro';
        src: url(/fonts/CrimsonPro-Italic.woff) format("woff");
        font-weight: 400;
        font-display: swap;
        font-style: italic
    }

    @font-face {
        font-family: 'CrimsonPro';
        src: url(/fonts/CrimsonPro-Medium.woff) format("woff");
        font-weight: 700;
        font-display: swap;
        font-style: normal
    }

    .container-cycle-col-2::after,
    .container-cycle-col-2::before,
    .container::after,
    .container::before,
    .section::after,
    .section::before,
    .site::after,
    .site::before,
    section::after,
    section::before {
        content: '';
        display: table
    }

    .container-cycle-col-2::after,
    .container::after,
    .section::after,
    .site::after,
    section::after {
        clear: both
    }

    @media screen and (min-width:1200) {
        .container{
            max-width: 1400px!important;
        }
        
    }

    @media screen and (min-width:960px) {
        .container{
            max-width: 1400px!important;
        }
        
    }

    @media screen and (min-width:960px) {
        .container{
            /** max-width: 1400px!important; **/
        }
        
    }


    picture {
        background-image: url(https://www.lifegate.it/app/themes/lifegate-2020/dist/images/loader_animation.svg);
        background-size: 32px;
        background-position: 50% 50%;
        background-repeat: no-repeat no-repeat;
        overflow: hidden;
        position: relative;
        height: 0;
        padding-bottom: 100%;
        background-color: #eee
    }

    .btn,
    .button--collapse,
    .cta--icon,
    .drawer-menu main .drawer-menu__block .drawer-menu__item,
    .header__block .header-btn,
    .radio-panel #radio-panel-btn,
    .trends--section .trendsSlider-nav {
        background-image: url(/images/icons.svg);
        background-size: 34px 2700px;
        background-repeat: no-repeat no-repeat
    }

    * {
        box-sizing: border-box
    }

    a,
    div,
    form,
    header,
    html,
    iframe,
    img,
    label,
    li,
    nav,
    span,
    strong,
    time,
    ul {
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 100%;
        vertical-align: baseline
    }

    body,
    h1,
    h2 {
        margin: 0
    }

    body,
    h1,
    h2,
    p,
    section {
        padding: 0;
        border: 0;
        vertical-align: baseline
    }

    section {
        font-size: 100%;
        margin: 0
    }

    header,
    img,
    nav,
    picture,
    section {
        display: block
    }

    ul {
        list-style: none
    }

    img {
        max-width: 100%;
        height: auto
    }

    input {
        outline: 0;
        border: 0;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        border-radius: 0
    }

    body {
        font-size: 16px;
        font-weight: 400;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
        font-family: "Nunito", Arial, sans-serif
    }

    .lazyloaded,
    picture img {
        min-width: 100%;
        min-height: 100%
    }

    picture img {
        display: block;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%)
    }

    .lazyloaded {
        max-width: 100%;
        -webkit-transition: all .3s ease-out;
        opacity: 1;
        transition: all ease-out .3s
    }

    h2 {
        font-size: 28px;
        line-height: 32px
    }

    a,
    p a {
        color: #000
    }

    body,
    p,
    p a {
        -webkit-font-smoothing: antialiased
    }

    p a {
        font-size: 18px;
        line-height: 26px
    }

    a {
        text-decoration: none;
        outline: 0 !important;
        cursor: pointer
    }

    .editorial strong,
    strong {
        font-weight: 700
    }

    @media print {
        .sidebar {
            display: none
        }
    }

    .wrapper {
        position: relative;
        width: 1012px;
        max-width: 100%;
        overflow: hidden;
        background-color: #fff;
        margin: 0 auto
    }

    @media screen and (max-width:736px) {
        .wrapper {
            width: 100%;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-radius: 0;
            padding: 0;
            margin: 0
        }
    }

    .wrapper>.container {
        position: relative;
        padding: 0 16px;
        margin: 0
    }

    @media screen and (min-width:960px) {
        .hide-desktop {
            display: none;
        }
    }

    @media screen and (max-width:960px) {
        .hide-mobile {
            display: none;
        }
    }

    @media screen and (max-width:736px) {
        .wrapper {
            width: 100%;
            border-radius: 0;
            padding: 0;
            margin: 0
        }

        .wrapper>.container {
            padding: 0 8px
        }
    }

    .container,
    section {
        position: relative
    }

    .main-content {
        width: calc(100% - 300px);
        padding-bottom: 24px
    }

    .main-content.main-content--left {
        float: left;
        padding-right: 40px
    }

    @media screen and (max-width:800px) {
        .main-content.main-content--left {
            width: 100%;
            float: none;
            padding: 0;
            clear: both
        }
    }

    .sidebar {
        min-width: 300px;
        width: 300px;
        min-height: 250px
    }

    .sidebar.sidebar--right {
        float: right
    }

    @media screen and (max-width:800px) {
        .sidebar {
            width: 100%;
            float: none;
            padding: 0 !important;
            min-height: 0
        }
    }

    .container-cycle-col-2>* {
        float: left;
        clear: none;
        text-align: inherit;
        width: 48.02372%;
        margin-left: 0;
        margin-right: 3.95257%
    }

    .container-cycle-col-2>:nth-child(n) {
        margin-right: 3.95257%;
        float: left;
        clear: none
    }

    .container-cycle-col-2>:nth-child(2n) {
        margin-right: 0;
        float: right
    }

    .container-cycle-col-2>:nth-child(2n+1) {
        clear: both
    }

    @media screen and (max-width:736px) {
        .container-cycle-col-2>* {
            float: left;
            clear: none;
            text-align: inherit;
            width: 100%;
            margin-left: 0;
            margin-right: 0
        }

        .container-cycle-col-2>:nth-child(n) {
            clear: none;
            margin-right: 0;
            float: right
        }

        .container-cycle-col-2>:nth-child(n+1) {
            clear: both
        }
    }

    .flex {
        display: flex
    }

    @media screen and (max-width:736px) {
        .flex {
            flex-direction: column
        }
    }

    @media screen and (max-width:900px) {
        .footer-immagine {
            width: 25%;
        }
    }

    .flex--column {
        flex-direction: column
    }

    .flex--center {
        align-items: center
    }

    .swiper-container {
        position: relative;
        overflow: hidden;
        list-style: none;
        z-index: 1;
        margin: 0 auto;
        padding: 0
    }

    .swiper-slide,
    .swiper-wrapper {
        width: 100%;
        height: 100%;
        position: relative;
        transition: -webkit-transform;
        -webkit-transition: -webkit-transform;
        -webkit-transition-property: -webkit-transform;
        -o-transition-property: transform;
        transition-property: transform;
        transition-property: transform, -webkit-transform
    }

    .swiper-wrapper {
        -webkit-transform: translate3d(0, 0, 0);
        z-index: 1;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-sizing: content-box;
        box-sizing: content-box
    }

    .swiper-slide {
        -webkit-flex-shrink: 0;
        -ms-flex-negative: 0;
        flex-shrink: 0
    }

    .base {
        overflow: hidden
    }

    .figcaption,
    h1,
    h2 {
        font-family: CrimsonPro, serif
    }

    h1,
    h2 {
        color: inherit
    }

    h2 {
        font-weight: 500
    }

    @media screen and (max-width:736px) {

        h1,
        h2 {
            font-family: CrimsonPro, serif;
            font-weight: 500
        }
    }

    h1 {
        font-size: 42px;
        font-weight: 500;
        line-height: 48px
    }

    .img-article{
        padding: 8.3% 0;
    }

    @media screen and (max-width:736px) {
        h1 {
            font-size: 36px;
            font-weight: 500;
            line-height: 44px;
            font-family: "CrimsonPro", serif
        }

        h2 {
            font-size: 32px;
            line-height: 38px
        }
    }

    p {
        font-weight: 400;
        font-size: 18px;
        line-height: 24px;
        margin: 0 0 12px;
        color: #5f5e5e;
        font-family: "CrimsonPro", serif
    }

    @media screen and (max-width:1400px) {
        p {
            font-size: 16px;
            line-height: 20px
        }
    }

    section {
        margin-bottom: 0
    }

    .figcaption {
        color: #5f5e5e;
        display: block;
        padding: 6px;
        text-align: right;
        font-size: 13px !important;
        line-height: 18px !important
    }

    .editorial {
        margin-bottom: 40px;
        --fontsize: 19px;
        --lineheight: 28px;
        font-family: "CrimsonPro", serif
    }

    .site .container {
        padding: 0;
    }

    .editorial h2 {
        margin: 24px 0 12px;
        font-size: 30px;
        line-height: 36px
    }

    .container-collaborazione {
        height: 6em;
    }

    .editorial,
    .editorial p {
        color: #000;
        font-size: var(--fontsize);
        line-height: var(--lineheight)
    }

    @media screen and (max-width:736px) {
        .editorial p {
            font-size: 18px;
            font-family: "Nunito", Arial, sans-serif
        }

        .footer-immagine {
            margin: 0 42.5% !important;
            width: 15% !important;
            height: auto !important;
        }

        .container-collaborazione {
            height: auto;
        }
    }

    .editorial p:last-child,
    .editorial p:last-of-type {
        margin-bottom: 0
    }

    .editorial a {
        color: #006454;
        font-size: var(--fontsize);
        line-height: var(--lineheight)
    }

    .btn--close {
        cursor: pointer;
        width: 38px;
        height: 38px;
        min-height: 38px;
        background-position: 12px -726px
    }

    .post__story {
        font-size: 15px;
        font-weight: 600;
        margin-right: 12px;
        color: #ef7b10
    }

    .post__story,
    a.post__story {
        text-transform: none
    }

    .site {
        max-width: 1400px;
        width: 100%;
        position: relative;
        margin: 0 auto
    }

    @media screen and (max-width:1400px) {
        .site {
            max-width: 1012px
        }
    }

    .site .container {
        padding: 0 16px
    }

    @media screen and (max-width:736px) {
        .site .container {
            padding: 0 8px
        }
    }

    .site .container>section {
        margin-bottom: 32px
    }

    .post__description {
        margin-bottom: 20px
    }

    .post__description p {
        font-size: 28px;
        font-style: italic;
        line-height: 34px
    }

    @media screen and (max-width:736px) {
        .post__description p {
            align-items: center;
            flex-direction: column;
            font-family: "CrimsonPro", serif
        }
    }

    .post__trends {
        margin-bottom: 24px;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        flex-direction: row;
        padding: 15px 0
    }

    @media screen and (max-width:736px) {
        .post__trends {
            align-items: center;
            flex-direction: column
        }
    }

    .post__trends>div>a {
        display: inline-block;
        font-weight: lighter;
        text-transform: uppercase;
        margin-right: 24px;
        color: #5f5e5e
    }

    @media screen and (max-width:736px) {
        .post__trends>div>a {
            margin: 6px 24px
        }
    }

    .single__hero-footer__box {
        margin: 0 0 20px;
        display: flex;
        flex-direction: column;
        align-items: flex-end
    }

    .single__hero-footer__box .single__hero-footer__datas {
        margin: 0
    }

    .single__hero-footer__datas {
        position: relative;
        display: flex;
        align-items: center;
        margin: 0 0 48px;
        flex-wrap: wrap
    }

    @media screen and (max-width:736px) {
        .single__hero-footer__datas {
            margin: 0 0 12px;
            justify-content: center
        }
    }

    .single__hero-footer__datas>* {
        border-right: 0;
        padding: 0 12px;
        margin: 6px 12px 6px 0
    }

    @media screen and (max-width:736px) {
        .single__hero-footer__datas>* {
            position: static;
            flex-direction: column;
            align-items: flex-start;
            left: 0;
            transform: none;
            margin: 6px 0;
            border: 0 !important
        }
    }

    .single__hero-footer__datas>:last-child {
        border: 0 !important
    }

    @media screen and (max-width:736px) {
        .single__hero-footer__datas>* {
            border: 0 !important;
            flex-direction: column;
            align-items: flex-start;
            left: 0;
            position: static;
            transform: none;
            border-right: none;
            margin: 6px 0
        }
    }

    .single__hero-footer__datas .post__date {
        font-size: 16px;
        padding-left: 0;
        padding-right: 0;
        margin-right: 0
    }

    .single__hero-footer__datas .post__date--it {
        text-transform: lowercase
    }

    .single__hero-footer__datas .post__author {
        color: #000;
        padding-left: 0
    }

    .single__hero-footer__datas .post__author a {
        text-decoration: underline;
        color: #006454
    }

    .single__title {
        margin-bottom: 20px
    }

    .single__title h1 {
        margin-bottom: 12px
    }

    @media screen and (max-width:736px) {
        .single__title {
            margin-bottom: 32px
        }
    }

    @media screen and (min-width:737px) {
        .single__title {
            flex-direction: row
        }
    }

    .single__title .post__story {
        font-size: 22px;
        margin: auto 32px auto 0
    }

    @media screen and (max-width:736px) {
        .single__title .post__story {
            margin: 10px auto 16px 0
        }
    }

    .section {
        margin: 0 0 40px;
        position: relative
    }

    .cta--sticky::before,
    .overlay {
        position: absolute;
        background-position: initial initial;
        background-repeat: initial initial
    }

    .overlay {
        opacity: 0;
        visibility: hidden;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .498039);
        z-index: 1;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, .5);
        will-change: opacity
    }

    .cta {
        background-color: transparent;
        display: inline-block;
        font-size: 16px;
        min-height: 38px;
        min-width: 38px;
        padding: 9px;
        text-transform: uppercase
    }

    .cta--icon-left {
        padding-left: 40px;
        background-position-x: left !important
    }

    .cta--enter {
        background-position: 0 calc(50% + 220px)
    }

    .cta--sticky {
        display: none;
        position: fixed;
        bottom: 60px;
        right: 12px;
        height: 50px;
        width: 50px;
        z-index: 10;
        max-height: none;
        background-position: -2px -1010px;
        background-size: 52px auto
    }

    @media screen and (max-width:736px) {
        .cta--sticky {
            display: block
        }
    }

    .cta--sticky::before {
        background-color: #fff;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
        border-bottom-left-radius: 4px;
        box-shadow: rgba(0, 0, 0, .298039) 0 3px 6px;
        content: attr(data-tooltip);
        padding: 6px;
        top: -56px;
        left: 50%;
        text-align: center
    }

    .cta--sticky::after {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-top-width: 10px;
        border-top-style: solid;
        border-top-color: #fff;
        border-left-width: 10px;
        border-left-style: solid;
        border-left-color: transparent;
        border-right-width: 10px;
        border-right-style: solid;
        border-right-color: transparent;
        top: -2px;
        left: 50%
    }

    .partial-social {
        max-width: 100%;
        width: calc(24px*var(--socialnumber) + (24px*(var(--socialnumber) - 1))) !important;
        margin: 0 auto;
        padding: 0
    }

    .main-menu__main ul,
    .main-menu__submenu-magazine ul,
    .partial-social ul {
        display: flex;
        justify-content: space-between
    }

    .partial-breadcrumb nav ul li:last-child,
    .partial-social .social:last-child {
        margin-right: 0
    }

    .partial-social .social a {
        display: block;
        width: 24px;
        height: 24px;
        background-image: url(https://www.lifegate.it/app/themes/lifegate-2020/dist/images/icon-social.svg);
        background-repeat: no-repeat;
        margin-right: 0
    }

    .partial-social .social--fb a {
        background-position: 0 -45px
    }

    .partial-social .social--tw a {
        background-position: 0 -134px
    }

    .partial-social .social--pn a {
        background-position: 0 -224px
    }

    .partial-social .social--sp a {
        background-position: 0 -315px
    }

    .partial-social .social--yt a {
        background-position: 0 -403px
    }

    .partial-social .social--in a {
        background-position: 0 -491px
    }

    .partial-social .social--ln a {
        background-position: 0 -584px
    }

    .partial-social .social--tg a {
        background-position: 0 -630px
    }

    .partial-social .social--pp a {
        background-position: 0 -766px
    }

    .partial-social--share {
        width: calc(24px*3 + (24px*(3 - 1))) !important
    }

    @media screen and (max-width:736px) {
        .partial-social--share {
            width: calc(24px*5 + (24px*(5 - 1))) !important
        }
    }

    .partial-social--share .social--pp,
    .partial-social--share .social--tg {
        display: none
    }

    @media screen and (max-width:736px) {

        .partial-social--share .social--pp,
        .partial-social--share .social--tg {
            display: block
        }
    }

    .drawer-menu__footer .partial-social {
        width: calc(24px*8 + (24px*(8 - 1))) !important
    }

    .post__trends>div+.partial-social {
        margin-right: 0
    }

    @media screen and (max-width:736px) {
        .post__trends>div+.partial-social {
            margin: 24px 0 0
        }
    }

    @media screen and (min-width:737px) {
        .partial-social:last-child {
            margin-right: 0
        }
    }

    @media screen and (max-width:736px) {
        .partial-social:last-child {
            margin: 12px auto
        }
    }

    .partial-social:first-child {
        margin-right: auto
    }

    .tbm-code.tbm-code-container.headofpage {
        margin: 0 auto 40px
    }

    @media screen and (max-width:736px) {
        .tbm-code.tbm-code-container.headofpage {
            margin: 0
        }
    }

    article[class^=card] picture svg.icon {
        border-top-left-radius: 50%;
        border-top-right-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
        display: none;
        position: absolute;
        z-index: 1;
        width: 26%;
        top: 50%;
        left: 50%
    }

    .single-post .single__featured-image {
        margin: 0
    }

    .single-post .single__featured-image picture {
        padding-bottom: 50%
    }

    .header__search {
        position: relative;
        height: 60px;
        min-width: 100px;
        align-items: center;
        display: flex
    }

    .header__search .search__field {
        position: absolute;
        -webkit-transition: all .2s ease-in-out;
        width: 420px;
        overflow: hidden;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        z-index: 1;
        display: flex;
        top: 0;
        align-items: center;
        transition: all ease-in-out .2s;
        padding: 8px 0
    }

    .header__search .search__field>* {
        margin: 0 6px
    }

    .header__search .search__field .btn--close {
        background-position: 4px -1513px
    }

    @media screen and (max-width:736px) {
        .header__search {
            display: none
        }
    }

    .header__search--drawer {
        display: block;
        width: 100%
    }

    @media screen and (min-width:737px) {
        .header__search--drawer {
            display: none
        }
    }

    .header__search--drawer .search__field {
        width: 100%;
        position: static;
        opacity: 1;
        visibility: visible
    }

    .header__search--drawer .search__field input {
        border: 1px solid transparent;
        color: #fff
    }

    .header {
        position: fixed;
        height: 60px;
        width: 100%;
        z-index: 10;
        top: 0
    }

    .header+div {
        max-width: 100vw;
        overflow: hidden
    }

    .header__block {
        height: 100%;
        position: absolute;
        width: 100%;
        z-index: 1;
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 16px
    }

    @media screen and (max-width:812px) {
        .header__block {
            padding: 0 8px
        }
    }

    @media screen and (max-width:736px) {
        .header__block {
            padding: 0
        }
    }

    .header__block__left {
        max-width: 300px;
        width: 23%;
        display: flex;
        align-items: center;
        justify-content: space-between
    }

    @media screen and (max-width:800px) {
        .header__block__left {
            width: 40%
        }
    }

    .header__block__middle {
        position: absolute;
        left: 50%;
        max-width: 130px;
        text-align: center;
        align-items: center;
        display: flex;
        justify-content: center;
        transform: translateX(-50%)
    }

    @media screen and (max-width:736px) {
        .header__block__middle {
            transform: translate(-50%, -2px)
        }
    }

    .header__block__middle .logo--light {
        display: none
    }

    .header__block .header-btn {
        cursor: pointer;
        font-weight: 700;
        height: 60px;
        padding: 6px;
        min-width: 90px;
        overflow: hidden;
        color: #5f5e5e;
        margin: 0
    }

    @media screen and (max-width:736px) {
        .header__block .header-btn {
            text-indent: -100px;
            min-width: 0;
            flex: 1
        }
    }

    @media screen and (max-width:812px) {
        .header__block .header-btn.header-btn--hamburger {
            min-width: 50px
        }

        .header__block .header-btn.header-btn--newsletter,
        .header__block .header-btn.header-btn--shop {
            text-indent: -130px;
            min-width: 0;
            flex: 1
        }
    }

    @media screen and (max-width:812px) and (min-width:768px) {

        .header__block .header-btn.header-btn--newsletter,
        .header__block .header-btn.header-btn--shop {
            max-width: 50px
        }
    }

    .header__block .header-btn--hamburger {
        background-position: 12px -142px
    }

    @media screen and (max-width:736px) {
        .header__block .header-btn--hamburger {
            background-position: 8px -142px;
            margin-right: 0
        }
    }

    .header__block .header-btn--shop {
        padding-left: 46px;
        line-height: 46px;
        background-position: 12px -82px
    }

    .header__block .header-btn--newsletter {
        padding-left: 46px;
        line-height: 46px;
        min-width: 130px;
        background-position: 12px -1463px
    }

    @media screen and (max-width:736px) {
        .header__block .header-btn--newsletter {
            display: none
        }
    }

    .header__block .header-btn--search {
        padding-left: 46px;
        line-height: 54px;
        background-position: 12px 5px
    }

    .header::after {
        content: '';
        height: 0;
        border-top-width: 15px;
        border-top-style: solid;
        border-top-color: rgba(0, 0, 0, .2);
        border-left-width: 30vw;
        border-left-style: solid;
        border-left-color: transparent;
        border-right-width: 30vw;
        border-right-style: solid;
        border-right-color: transparent;
        bottom: -7px;
        position: absolute;
        width: 100%
    }

    .radio-panel .transparent {
        cursor: pointer;
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 1;
        left: 0;
        top: 0
    }

    @media screen and (max-width:812px) {
        .radio-panel {
            flex-direction: row-reverse
        }
    }

    .radio-panel .equalizer-container {
        position: relative;
        width: 56px;
        height: 44px;
        overflow: hidden;
        transform: rotate(90deg)
    }

    @media screen and (max-width:812px) {
        .radio-panel .equalizer-container {
            margin-right: -15px;
            transform: rotate(-90deg)
        }
    }

    .radio-panel #radio-panel-btn {
        cursor: pointer;
        padding-right: 40px;
        min-height: 48px;
        background-position: right 0 top -346px;
        align-items: center;
        justify-content: center
    }

    .radio-panel #radio-panel-btn label {
        display: -webkit-box;
        height: 24px;
        text-overflow: ellipsis;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
        overflow: hidden;
        position: relative;
        width: 180px;
        display: block
    }

    .radio-panel #radio-panel-btn label.radio-panel__title {
        padding-left: 8px;
        text-align: center
    }

    @media screen and (max-width:812px) {
        .radio-panel #radio-panel-btn label.radio-panel__title {
            display: none !important
        }
    }

    .radio-panel #radio-panel-btn label.radio-panel__artist {
        font-size: 11px;
        font-weight: 700;
        text-align: center;
        color: #add6b7
    }

    @media screen and (max-width:812px) {
        .radio-panel #radio-panel-btn label.radio-panel__artist {
            display: none !important
        }
    }

    .sk-chase {
        width: 40px;
        height: 40px;
        position: relative;
        animation: sk-chase 2.5s infinite linear both
    }

    .sk-chase-dot {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        animation: sk-chase-dot 2s infinite ease-in-out both
    }

    .sk-chase-dot::before {
        content: '';
        display: block;
        width: 25%;
        height: 25%;
        background-color: #fff;
        border-top-left-radius: 100%;
        border-top-right-radius: 100%;
        border-bottom-right-radius: 100%;
        border-bottom-left-radius: 100%
    }

    .sk-chase-dot:nth-child(1) {
        animation-delay: -1.1s
    }

    .sk-chase-dot:nth-child(2) {
        animation-delay: -1s
    }

    .sk-chase-dot:nth-child(3) {
        animation-delay: -.9s
    }

    .sk-chase-dot:nth-child(4) {
        animation-delay: -.8s
    }

    .sk-chase-dot:nth-child(5) {
        animation-delay: -.7s
    }

    .sk-chase-dot:nth-child(6) {
        animation-delay: -.6s
    }

    .trends--section {
        padding: 5px 16px;
        position: relative;
        margin: 12px auto;
        display: flex;
        align-items: center
    }

    @media screen and (max-width:736px) {
        .trends--section {
            padding: 5px 12px;
            flex-direction: column
        }
    }

    .trends--section>div {
        text-align: center
    }

    .trends--section .trends-section__container {
        overflow: hidden;
        height: 100%;
        max-height: 37px;
        position: relative;
        visibility: hidden;
        width: 100%
    }

    @media screen and (max-width:736px) {
        .trends--section .trends-section__container {
            min-width: 80%
        }
    }

    .trends--section .trends-section__container .swiper-wrapper {
        align-items: center;
        width: fit-content
    }

    .trends--section .trends-section__container .swiper-wrapper .swiper-slide {
        padding: 8px 24px;
        height: auto;
        width: auto !important;
        margin: 0 6px
    }

    .bg-cover {
        background-size: cover !important;
    }

    @media screen and (max-width:736px) {
        .trends--section .trends-section__container .swiper-wrapper .swiper-slide {
            padding: 8px;
            margin: 0 4px
        }

        .trends--section .trends-section__container .swiper-wrapper .swiper-slide:first-child {
            margin-left: 0
        }
    }

    .trends--section .trends-section__container a {
        font-size: 14px;
        font-weight: 400;
        border: 1px solid transparent;
        -webkit-transition: all .3s ease-out;
        text-transform: uppercase;
        color: #5f5e5e;
        transition: all ease-out .3s
    }

    .trends--section .trendsSlider-nav {
        cursor: pointer;
        position: absolute;
        width: 24px;
        height: 24px;
        opacity: 1;
        padding: 24px;
        -webkit-transition: all .3s ease-out;
        visibility: hidden;
        z-index: 1;
        background-color: #fff;
        top: 0;
        transition: all ease-out .3s
    }

    .trends--section .trendsSlider-nav.trendsSlider__prev {
        background-position: 3px -526px;
        box-shadow: 10px 0 8px -8px rgba(0, 0, 0, .3);
        left: 0
    }

    @media screen and (max-width:736px) {
        .trends--section .trendsSlider-nav.trendsSlider__prev {
            left: 10px
        }
    }

    .trends--section .trendsSlider-nav.trendsSlider__next {
        background-position: 3px -461px;
        box-shadow: -10px 0 8px -8px rgba(0, 0, 0, .3);
        right: 0
    }

    .main-menu {
        padding: 16px 0
    }

    @media screen and (max-width:736px) {
        .main-menu {
            display: none
        }
    }

    .main-menu__main ul li a {
        font-size: 24px;
        font-weight: 700
    }

    .main-menu__main ul li a.special-trend {
        color: #006454
    }

    .main-menu__submenu-magazine {
        margin-top: 24px;
        border-bottom: 1px solid #add6b7
    }

    .main-menu__submenu-magazine ul li a {
        color: #add6b7
    }

    .partial-breadcrumb {
        overflow: hidden;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        padding: 0;
        margin: 0 0 24px
    }

    .partial-breadcrumb nav {
        height: 48px;
        overflow: hidden;
        display: flex;
        align-items: center
    }

    @media screen and (max-width:800px) {
        .partial-breadcrumb nav {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch
        }
    }

    .partial-breadcrumb nav ul,
    .partial-breadcrumb nav ul li {
        white-space: nowrap;
        display: flex;
        align-items: baseline
    }

    .partial-breadcrumb nav ul li {
        position: relative;
        line-height: 24px;
        padding-right: 16px;
        margin-right: 10px;
        font-family: "CrimsonPro", serif;
        align-items: center
    }

    .partial-breadcrumb nav ul li::after {
        content: ›;
        position: absolute;
        color: #ddd;
        font-size: 24px;
        top: -4px;
        right: 0;
        display: block;
        line-height: 24px
    }

    .partial-breadcrumb nav ul li:last-child::after {
        display: none
    }

    .partial-breadcrumb nav ul li span {
        display: block;
        line-height: 24px
    }

    .partial-breadcrumb nav ul li a {
        font-family: inherit;
        font-weight: 600;
        line-height: 24px;
        position: relative;
        max-width: 190px;
        display: -webkit-box;
        height: 24px;
        text-overflow: ellipsis;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
        overflow: hidden;
        color: #006454;
        display: block
    }

    @media screen and (max-width:736px) {
        .partial-breadcrumb nav ul li a {
            max-width: none;
            overflow: visible;
            text-overflow: inherit
        }
    }

    .partial-breadcrumb nav ul li .current-item {
        display: block;
        max-width: 360px
    }

    @media screen and (max-width:736px) {
        .partial-breadcrumb nav ul li .current-item {
            max-width: none;
            overflow: visible;
            text-overflow: inherit
        }
    }

    input[type=text],
    select {
        background-color: transparent;
        display: block;
        width: 100%;
        height: inherit;
        min-height: 34px;
        color: #000;
        font-family: Nunito, Arial, sans-serif;
        font-style: italic;
        font-size: 15px;
        line-height: 28px;
        text-align: left;
        vertical-align: middle;
        background-image: none;
        background-clip: padding-box;
        border: 1px solid #ddd;
        padding: 8px 10px;
        margin: 0;
        outline: 0;
        transition: border .3s ease-out;
        -webkit-transition: border .3s ease-out
    }

    input[type=text] {
        font-family: Nunito, Arial, sans-serif !important
    }

    button {
        cursor: pointer
    }

    .dropdown,
    .input-field>label {
        font-family: "Nunito", Arial, sans-serif
    }

    .dropdown {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        min-height: 32px;
        font-style: normal;
        font-weight: 700;
        font-size: 14px;
        background-image: url(https://www.lifegate.it/app/themes/lifegate-2020/dist/images/icons.svg) !important;
        background-repeat: no-repeat;
        border-radius: 0
    }

    @media screen and (max-width:800px) {
        .dropdown {
            background-color: transparent !important;
            padding-right: 40px !important;
            background-position: right 1px top -1728px !important
        }
    }

    .input-field {
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        flex-wrap: wrap
    }

    @media screen and (max-width:736px) {
        .input-field {
            align-items: flex-start;
            flex-direction: column
        }
    }

    .input-field>label {
        font-size: 16px;
        line-height: 24px;
        margin-right: 10px;
        min-width: 115px;
        white-space: nowrap
    }

    @media screen and (max-width:736px) {
        .input-field.input-field--select {
            position: relative
        }
    }

    .search__field input[type=text] {
        padding: 12px
    }

    .search__field .search__field__submit {
        border: 0;
        min-height: 36px;
        width: 40px;
        margin: 0 24px 0 6px
    }

    @media screen and (max-width:414px) {
        .search__field .search__field__submit {
            margin: 0 6px
        }
    }

    @media screen and (device-aspect-ratio:2/3) {

        input[type=text],
        select {
            font-size: 13px !important
        }
    }

    @media screen and (device-aspect-ratio:40/71) {

        input[type=text],
        select {
            font-size: 13px !important
        }
    }

    @media screen and (device-aspect-ratio:375/667) {

        input[type=text],
        select {
            font-size: 16px !important
        }
    }

    @media screen and (device-aspect-ratio:9/16) {

        input[type=text],
        select {
            font-size: 16px !important
        }
    }

    article.card-post-special .card__thumbnail--big picture svg.icon {
        display: none;
        position: absolute;
        z-index: 1;
        width: 20%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%)
    }

    .drawer-menu__menu {
        min-height: 100vh;
        position: fixed;
        width: 100%;
        max-width: 430px;
        z-index: 1010000000;
        left: -431px;
        -webkit-transition: left .2s ease-out;
        background-color: #fff;
        transition: left ease-out .2s;
        top: 0;
        will-change: transform
    }

    @media screen and (max-width:812px) {
        .drawer-menu__menu {
            min-height: -webkit-fill-available
        }
    }

    .drawer-menu .overlay {
        position: fixed;
        -webkit-transition: all .2s ease-out;
        z-index: 100;
        transition: all ease-out .2s
    }

    .drawer-menu a {
        display: inline-block;
        font-size: 18px;
        text-transform: none;
        color: #5f5e5e
    }

    .drawer-menu header {
        height: 70px;
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        background-color: #006454
    }

    @media screen and (max-width:736px) {
        .drawer-menu header {
            height: 124px
        }
    }

    .drawer-menu header .header__top {
        height: 54px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 8px
    }

    .drawer-menu header .drawer-menu__lang {
        margin: 0;
        width: min-content
    }

    .drawer-menu header .drawer-menu__lang select#drawer-menu>* {
        color: #000 !important
    }

    .drawer-menu header .drawer-menu__lang .dropdown {
        font-style: normal;
        text-transform: uppercase;
        border: 0;
        color: #fff;
        background-position: right 0 top -38px !important
    }

    .drawer-menu main {
        position: absolute;
        height: calc(100% - 118px);
        overflow: auto;
        width: 100%;
        -webkit-overflow-scrolling: touch
    }

    @media screen and (max-width:736px) {
        .drawer-menu main {
            height: calc(100% - 196px)
        }
    }

    .drawer-menu main .drawer-menu__block {
        padding: 5%;
        border-bottom: 1px solid #454545
    }

    .drawer-menu main .drawer-menu__block .drawer-menu__item {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 32px;
        padding-right: 40px;
        text-transform: uppercase !important;
        background-position: right -8px top -598px;
        color: #5f5e5e
    }

    @media screen and (max-width:736px) {
        .drawer-menu main .drawer-menu__block .drawer-menu__item+.flex {
            flex-direction: row
        }
    }

    .drawer-menu main .drawer-menu__block .drawer-menu__block__submenu {
        padding: 6px;
        flex: 1
    }

    .drawer-menu main .drawer-menu__block .drawer-menu__block__submenu ul li {
        margin-bottom: 24px
    }

    .drawer-menu .drawer-menu__footer {
        background-color: #fff;
        position: absolute;
        width: 100%;
        padding: 12px 5%;
        background-position: initial initial;
        background-repeat: initial initial;
        background: #fff;
        bottom: 0
    }

    .fullwidth-image .featured-image__box-image {
        overflow: hidden;
        position: relative;
        width: 100%;
        height: 100%
    }

    .fullwidth-image .featured-image--fullwidth-image {
        -webkit-transition: opacity .3s ease-out;
        position: fixed;
        opacity: 0;
        visibility: hidden;
        transition: opacity ease-out .3s;
        width: 96vw;
        height: 96vh;
        left: 2vw;
        top: 2vh;
        z-index: -1;
        backface-visibility: hidden
    }

    .fullwidth-image .featured-image--fullwidth-image .featured-image__box-image {
        top: 50%;
        -webkit-transition: .4s cubic-bezier(.18, .89, .32, 1.28);
        z-index: 101;
        transform: translateY(-50%);
        transition: cubic-bezier(.18, .89, .32, 1.28) .4s
    }

    .fullwidth-image .featured-image--fullwidth-image .fullwidth-image__footer {
        position: absolute;
        bottom: -1px;
        background-color: rgba(0, 0, 0, .8);
        width: 100%;
        z-index: 101;
        padding: 24px;
        -webkit-transition: opacity .2s ease-out;
        background-position: initial initial;
        background-repeat: initial initial;
        display: flex;
        align-items: center;
        background: rgba(0, 0, 0, .8);
        transition: opacity ease-out .2s
    }

    @media screen and (max-width:812px) and (orientation:landscape) {
        .fullwidth-image .featured-image--fullwidth-image .fullwidth-image__footer {
            padding: 24px 80px
        }
    }

    .fullwidth-image .featured-image--fullwidth-image .fullwidth-image__footer * {
        color: #fff
    }

    .fullwidth-image .featured-image--fullwidth-image .fullwidth-image__footer>div:first-child {
        display: flex;
        align-items: center
    }

    .fullwidth-image .featured-image--fullwidth-image .fullwidth-image__footer>div:first-child label {
        padding-left: 12px;
        border-left: 1px solid #fff
    }

    @media screen and (max-width:812px) {
        .fullwidth-image .featured-image--fullwidth-image .fullwidth-image__footer>div:first-child {
            width: 100%;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start
        }

        .fullwidth-image .featured-image--fullwidth-image .fullwidth-image__footer>div:first-child label {
            border: 0;
            padding: 8px 0 0
        }
    }

    .button,
    .button--collapse {
        cursor: pointer;
        display: block
    }

    .button {
        background-color: transparent;
        min-height: 70px;
        -webkit-transition: background-color .2s ease-out;
        transition: background-color ease-out .2s
    }

    .button--collapse {
        width: 32px;
        height: 32px;
        background-position: 9px -729px;
        min-height: 0
    }

    .fullwidth-image .featured-image--fullwidth-image .swiper-container {
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        border-bottom-left-radius: 8px;
        overflow: hidden;
        width: 100%;
        height: 100%;
        position: relative;
        border-radius: 8px;
        display: flex;
        align-items: center
    }

    .fullwidth-image .featured-image--fullwidth-image .swiper-container .swiper-wrapper {
        width: auto;
        align-items: center
    }

    .fullwidth-image .featured-image--fullwidth-image .single-gallery-slider__nav .button--collapse {
        position: absolute;
        right: 8px;
        top: 8px;
        z-index: 101
    }

    .fullwidth-image__overlay {
        position: fixed;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        z-index: -1;
        background-color: rgba(0, 0, 0, .95);
        top: 0;
        left: 0
    }

    .partial-sticky-adv {
        width: 300px;
        min-height: 250px;
        max-height: 600px;
        margin: 0 auto
    }

    @media screen and (max-width:800px) {
        .partial-sticky-adv {
            margin: 32px auto;
            min-height: 0
        }
    }

    .partial-sticky-adv .sticky-element {
        width: 300px;
        min-height: 250px;
        transition: none !important;
        -webkit-transition: none !important;
        margin: 0 auto 24px;
        backface-visibility: hidden;
        will-change: top, scroll-position
    }

    @media screen and (max-width:800px) {
        .partial-sticky-adv .sticky-element {
            min-height: 0
        }
    }

    .sticky-adv {
        position: relative;
        width: 300px;
        min-height: 250px;
        max-height: 600px;
        background-color: #ddd;
        background-position: initial initial;
        background-repeat: initial initial;
        background: #ddd;
        background-size: 48px auto;
        margin: 0 auto
    }

    .sticky-adv::before {
        content: advertising;
        position: absolute;
        top: 55%;
        left: 0;
        width: 100%;
        color: #bbb;
        font-size: 13px;
        font-weight: 500;
        line-height: 32px;
        text-transform: uppercase;
        text-align: center;
        z-index: 0
    }

    @media screen and (max-width:736px) {
        .sticky-adv::before {
            display: none
        }
    }

    .sticky-adv * {
        position: relative !important;
        padding: 0;
        margin: 0
    }

    @media screen and (max-width:800px) {
        .sticky-adv {
            min-height: 0
        }

        .single__featured-image picture,
        .single__featured-image picture img {
            min-height: none;
            height: calc((100vw - 20px)*.5);
            padding: 0
        }
    }

    .swiper-lazy:not(.swiper-lazy-loaded) {
        display: none
    }

    .button--next,
    .button--prev {
        display: none
    }

    .headerRSS {
        -webkit-text-size-adjust: 100%;
        -webkit-tap-highlight-color: transparent;
        --blue: #007bff;
        --indigo: #6610f2;
        --purple: #6f42c1;
        --pink: #e83e8c;
        --red: #dc3545;
        --orange: #fd7e14;
        --yellow: #ffc107;
        --green: #28a745;
        --teal: #20c997;
        --cyan: #17a2b8;
        --white: #fff;
        --gray: #6c757d;
        --gray-dark: #343a40;
        --primary: #007bff;
        --secondary: #6c757d;
        --success: #28a745;
        --info: #17a2b8;
        --warning: #ffc107;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #343a40;
        --breakpoint-xs: 0;
        --breakpoint-sm: 576px;
        --breakpoint-md: 768px;
        --breakpoint-lg: 992px;
        --breakpoint-xl: 1200px;
        --font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        line-height: 1.5;
        text-align: left;
        font-family: "Nunito", Arial, sans-serif;
        font-weight: 400;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
        box-sizing: border-box;
        margin: 0;
        border: 0;
        font-size: 100%;
        vertical-align: baseline;
        padding: 2rem 1rem;
        margin-bottom: 2rem;
        border-radius: .3rem;
        color: #fff !important;
        background-size: cover !important;
        max-width: 100vw;
        overflow: hidden;
        background: url(https://bootstrapious.com/i/snippets/sn-static-header/background.jpg);
    }

    .headerRSS .container {
        -webkit-text-size-adjust: 100%;
        -webkit-tap-highlight-color: transparent;
        --blue: #007bff;
        --indigo: #6610f2;
        --purple: #6f42c1;
        --pink: #e83e8c;
        --red: #dc3545;
        --orange: #fd7e14;
        --yellow: #ffc107;
        --green: #28a745;
        --teal: #20c997;
        --cyan: #17a2b8;
        --white: #fff;
        --gray: #6c757d;
        --gray-dark: #343a40;
        --primary: #007bff;
        --secondary: #6c757d;
        --success: #28a745;
        --info: #17a2b8;
        --warning: #ffc107;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #343a40;
        --breakpoint-xs: 0;
        --breakpoint-sm: 576px;
        --breakpoint-md: 768px;
        --breakpoint-lg: 992px;
        --breakpoint-xl: 1200px;
        --font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        line-height: 1.5;
        font-family: "Nunito", Arial, sans-serif;
        font-weight: 400;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
        color: #fff !important;
        box-sizing: border-box;
        margin: 0;
        border: 0;
        font-size: 100%;
        vertical-align: baseline;
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
        max-width: 1140px;
        padding-top: 3rem !important;
        padding-bottom: 3rem !important;
        text-align: center !important;
        position: relative;
    }

    .headerRSS .container p {
        color: white;
    }
    </style>
    <link rel="stylesheet" href="https://www.lifegate.it/app/themes/lifegate-2020/dist/css/custom.min.css?ver=1.95.3"
        media="print" onload="this.media='all'">
    <link rel="apple-touch-icon" sizes="180x180"
        href="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/favicon-16x16.png">
    <link rel="mask-icon" color="#5bbad5"
        href="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/safari-pinned-tab.svg">
    <link rel="apple-touch-icon" sizes="180x180"
        href="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="194x194"
        href="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/favicon-194x194.png">
    <link rel="icon" type="image/png" sizes="192x192"
        href="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/favicon-16x16.png">
    <link rel="mask-icon" href="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/safari-pinned-tab.svg"
        color="#005039">
    <link rel="shortcut icon" href="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="msapplication-config"
        content="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/browserconfig.xml">
    <meta name="theme-color" content="#15907E">
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <script type="text/javascript">
    var lang_id = document.getElementsByTagName('html')[0].getAttribute('lang').split('-')[0],
        site_id = 2077371; // site_id dal codice di integrazione di iubendaconsole.log("lang:" + lang_id);
    switch (lang_id) {
        case 'en':
            var policy_id = 29441043; // policy_id dal codice di integrazione di iubenda (EN)
            break;
        case 'it':
            var policy_id = 12095617; // policy_id dal codice di integrazione di iubenda (IT)
            break;
    }
    </script>
    <script>
    var iCallback = function() {};
    var _iub = _iub || {};

    if (typeof _iub.csConfiguration != 'undefined') {
        if ('callback' in _iub.csConfiguration) {
            if ('onConsentGiven' in _iub.csConfiguration.callback)
                iCallback = _iub.csConfiguration.callback.onConsentGiven;

            _iub.csConfiguration.callback.onConsentGiven = function() {
                iCallback();

                /* separator */
                jQuery('noscript._no_script_iub').each(function(a, b) {
                    var el = jQuery(b);
                    el.after(el.html());
                });
            }
        }
    }
    </script>
    <title>Strategia Climatica in collaborazione con Pool Ambiente - LifeGate</title>

    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta property="og:locale" content="it_IT" />
    <meta property="og:title" content="Strategia Climatica in collaborazione con Pool Ambiente - LifeGate" />
    <meta property="og:site_name" content="LifeGate" />
    <meta property="article:publisher" content="https://www.facebook.com/lifegate/" />
    <meta property="article:tag" content="sviluppo sostenibile" />
    <meta property="article:tag" content="Transizione Climatica" />
    <meta property="article:tag" content="Transizione energetica" />
    <meta name="twitter:creator" content="@lifegate" />
    <link rel="stylesheet"
        href="https://www.lifegate.it/app/plugins/allow-webp-image/public/css/allow-webp-image-public.css?ver=1.0.1">
    <link rel="stylesheet" href="https://www.lifegate.it/app/plugins/wp-pagenavi/pagenavi-css.css?ver=2.70">
    <link rel="stylesheet"
        href="https://www.lifegate.it/app/themes/lifegate-2020/dist/css/components/partials/forms.min.css?ver=1.95.3">
    <style type="text/css">
    .wprm-comment-rating svg {
        width: 18px !important;
        height: 18px !important;
    }

    img.wprm-comment-rating {
        width: 90px !important;
        height: 18px !important;
    }

    .wprm-comment-rating svg path {
        fill: #343434;
    }

    .wprm-comment-rating svg polygon {
        stroke: #343434;
    }

    .wprm-comment-ratings-container svg .wprm-star-full {
        fill: #343434;
    }

    .wprm-comment-ratings-container svg .wprm-star-empty {
        stroke: #343434;
    }

    .wprm-recipe-template-lifegate-no-head .wprm-recipe-name,
    .wprm-recipe-template-lifegate-no-head .wprm-recipe-header {
        color: #000 !important;
    }
    </style>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "NewsMediaOrganization",
        "url": "https://www.lifegate.it",
        "logo": "https://cdn.lifegate.it/0nPiIdREB8IP_raN9lnx0a5yRYI=/180x180/smart/https://www.lifegate.it/app/uploads/2020/09/logo-lg.png"
    }
    </script>
    <link rel="preload"
        imagesrcset="https://cdn.lifegate.it/rMX8xpS5ta1oWxdC4G3_deq0QY0=/360x180/smart/https://www.lifegate.it/app/uploads/2021/11/commissione-europea.jpg, https://cdn.lifegate.it/NuIyvPgxUdcuRUWJfMu6KAhJhdk=/720x360/smart/https://www.lifegate.it/app/uploads/2021/11/commissione-europea.jpg 2x"
        as="image" media="(max-width: 736px)">
    <link rel="preload"
        imagesrcset="https://cdn.lifegate.it/tA7rv3EvCz0OrxIh7JEEulogqOA=/980x490/smart/https://www.lifegate.it/app/uploads/2021/11/commissione-europea.jpg, https://cdn.lifegate.it/12FpaKvpdTcMLI8d0Haek1Ecv6o=/1960x980/smart/https://www.lifegate.it/app/uploads/2021/11/commissione-europea.jpg 2x"
        as="image" media="(min-width: 736.1px)">
    <style>
    div#wpadminbar {
        top: auto;
        bottom: 0;
        position: fixed
    }

    .ab-sub-wrapper {
        bottom: 32px
    }

    html[lang] {
        margin-top: 0 !important;
        margin-bottom: 32px !important
    }

    @media screen and (max-width:782px) {
        .ab-sub-wrapper {
            bottom: 46px
        }

        html[lang] {
            margin-bottom: 46px !important
        }
    }
    </style>
    <style type="text/css" id="wp-custom-css">
    .lazyloaded {
        transition: none !important;
    }
    </style>
    <style>
    .editorial blockquote cite {
        font-size: 80%;
    }


    .lg-mycap-text {
        color: #5f5e5e;
        display: block;
        font-family: CrimsonPro, serif;
        font-size: 14px !important;
        line-height: 18px !important;
        padding: 6px;
        text-align: right;
    }

    .editorial p:last-of-type {
        margin-bottom: 12px;
    }


    .editorial .embed-responsive {
        margin-bottom: 12px;
    }

    .fullwidth-gallery .featured-image--fullwidth-image .swiper-container .swiper-wrapper .swiper-slide img {
        border-radius: 0 !important;
    }

    @media all and (max-width: 736px) {

        .hero-speciale__partner-container .cardpartner {
            margin-bottom: 0;
        }


        article.card-evento-big .card__main-container .card__footer {
            padding: 4px 0 20px 24px !important;
        }
    }
    </style>
    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
    <script>
    window.googletag = window.googletag || {
        cmd: []
    };
    googletag.cmd.push(function() {
        googletag.defineSlot('/228439431/skin', [1, 1], 'div-gpt-ad-1643303840623-0').addService(googletag
            .pubads());
        googletag.defineSlot('/228439431/Medium_1', [300, 250], 'div-gpt-ad-1643476494092-0').addService(
            googletag.pubads());
        googletag.defineSlot('/228439431/Medium_2', [300, 250], 'div-gpt-ad-1643476541204-0').addService(
            googletag.pubads());
        googletag.defineSlot('/228439431/lifegate.it/masthead-display', [
            [728, 90],
            [320, 100]
        ], 'div-gpt-ad-1643122318119-0').addService(googletag.pubads());
        googletag.defineSlot('/228439431/Staging_Article_Top', [300, 250], 'div-gpt-ad-1644590156846-0')
            .addService(googletag.pubads());
        googletag.defineSlot('/228439431/Staging_Article_Middle', [300, 250], 'div-gpt-ad-1644222756844-0')
            .addService(googletag.pubads());
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
    });
    </script>
    <style>
    @media screen and (min-width: 800px) {
        .only-mobile {
            display: none;
        }
    }
    </style>

</head>

<body class="sticky-parent">

    <div class="base sticky-kit chosen-js main-lifegate-js">

        <header class="header">
            <div class="header__block">
                <div class="header__block__middle">
                    <a href="/" class="logo logo--green" title="LifeGate">
                        <img src="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/logo-lifegate.svg"
                            width="130" height="27" alt="LifeGate" title="LifeGate" /></a>
                    <a href="/" class="logo logo--light" title="LifeGate">
                        <img src="https://www.lifegate.it/app/themes/lifegate-2020/dist/images/logo-lifegate-light.svg"
                            width="130" height="27" alt="LifeGate" title="LifeGate" />
                    </a>
                </div>
            </div>
        </header>
        <div style="background: url(https://bootstrapious.com/i/snippets/sn-static-header/background.jpg)"
            class="hide-mobile jumbotron bg-cover text-white">
            <div class="container py-5 float-left">
                <h1 class="display-4 font-weight-bold">Strategia climatica</h1>
                <p class="mb-0 text-white">Fare business rispettando il pianeta è possibile. Anzi, necessario. Il
                    mercato ormai premia le imprese che si dimostrano proattive, adottando tecnologie e processi volti a
                    ridurre l’impatto ambientale e la carbon footprint dei propri prodotti e servizi. Oltre alle
                    preferenze dei consumatori, anche le linee guida internazionali ed europee vanno sempre più in
                    questa direzione.<br />
                    Abbiamo selezionato gli strumenti e le risorse utili per le aziende che vogliono diventare
                    protagoniste del cambiamento.
                </p>
            </div>
        </div>

        <div class="hide-desktop jumbotron bg-cover text-white headerRSS">
            <div class="container py-5 text-center">
                <h1 class="display-4 font-weight-bold">Strategia climatica</h1>
                <p class="mb-0 text-white">Fare business rispettando il pianeta è possibile. Anzi, necessario. Il
                    mercato ormai premia le imprese che si dimostrano proattive, adottando tecnologie e processi volti a
                    ridurre l’impatto ambientale e la carbon footprint dei propri prodotti e servizi. Oltre alle
                    preferenze dei consumatori, anche le linee guida internazionali ed europee vanno sempre più in
                    questa direzione.
                    Abbiamo selezionato gli strumenti e le risorse utili per le aziende che vogliono diventare
                    protagoniste del cambiamento.
                </p>
            </div>
        </div>

        <div class="single  single-post " bis_skin_checked="1">
            <div class="site" bis_skin_checked="1">
                <link rel="stylesheet"
                    href="https://www.lifegate.it/app/themes/lifegate-2020/dist/css/single-post.min.css" media="all"
                    onload="this.media='all'">
                <div class="wrapper" bis_skin_checked="1">
                    <div class="container" bis_skin_checked="1">

                        <link rel="stylesheet"
                            href="https://www.lifegate.it/app/themes/lifegate-2020/dist/css/components/partials/main-menu.min.css"
                            media="all" onload="this.media='all'">
                    </div>
                </div>

                <div class="wrapper" style="width:1400px" bis_skin_checked="1">
                    <div class="container" bis_skin_checked="1">

                        <div>
                            <div class="title-section " bis_skin_checked="1" style="
                                                                                flex-direction: column;
                                                                                padding: 0 0 5px;
                                                                                margin: 16px 0;
                                                                                overflow: hidden;
                                                                                width: 100%;
                                                                            ">
                                <span class="bottom_line"></span>
                                <div bis_skin_checked="1">
                                    <span style="
                                                    color: #000;
                                                    font-family: &quot;Nunito&quot;,Arial,sans-serif;
                                                    font-size: 30px;
                                                    font-weight: 500;
                                                    line-height: 40px;
                                                    padding: 0 10px 0 0;
                                            ">Transizione climatica </span>
                                    <p class="abstract">I concetti fondamentali sulla crisi climatica e soprattutto
                                        sulle possibili soluzioni, spiegati in modo semplice e divulgativo.</p>
                                </div>
                            </div>
                            <?php echo readArticleFromInformationList($transizioneClimatica) ?>
                        </div>

                        <div>
                            <div class="title-section " bis_skin_checked="1" style="
                                                                                flex-direction: column;
                                                                                padding: 0 0 5px;
                                                                                margin: 16px 0;
                                                                                overflow: hidden;
                                                                                width: 100%;
                                                                            ">
                                <span class="bottom_line"></span>
                                <div bis_skin_checked="1">
                                    <span style="
                                                    color: #000;
                                                    font-family: &quot;Nunito&quot;,Arial,sans-serif;
                                                    font-size: 30px;
                                                    font-weight: 500;
                                                    line-height: 40px;
                                                    padding: 0 10px 0 0;
                                            ">News </span>

                                    <p class="abstract">Ambiente, energia, economia, tecnologia: le ultime notizie che
                                        ruotano attorno al mondo della sostenibilità. </p>
                                </div>
                            </div>
                            <?php echo readXmlFromUrlAndReturnHtml('https://www.lifegate.it/ambiente/rss') ?>
                        </div>

                        <div>
                            <div class="title-section " bis_skin_checked="1" style="
                                                                                flex-direction: column;
                                                                                padding: 0 0 5px;
                                                                                margin: 16px 0;
                                                                                overflow: hidden;
                                                                                width: 100%;
                                                                            ">
                                <span class="bottom_line"></span>
                                <div bis_skin_checked="1">
                                    <span style="
                                                    color: #000;
                                                    font-family: &quot;Nunito&quot;,Arial,sans-serif;
                                                    font-size: 30px;
                                                    font-weight: 500;
                                                    line-height: 40px;
                                                    padding: 0 10px 0 0;
                                            ">Best practices </span>
                                    <p class="abstract">Le storie di aziende – italiane e internazionali – che puntano
                                        sulla sostenibilità economica, ambientale e sociale. </p>
                                </div>
                            </div>
                            <?php echo readArticleFromInformationList($bestPratices) ?>
                        </div>


                    </div>

                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="footer__bottom">
                <div class="wrapper" style="margin:0 10px;width:90%">
                    <div class="container col-3">
                        <p class="pull-left float-left text-white" style="color:white">Per maggiori informazioni<br />
                            scrivi a <a href="mailto:imprese@lifegate.it" style="color:white">imprese@lifegate.it</a>
                        </p>

                    </div>

                    <div class="col-4 float-right container-collaborazione" style="">
                        <p class="col-6" style="color:white;margin-right:0">In collaborazione con</p>
                        <img class="col-4 footer-immagine" style="margin-right:0;width:auto;padding:2% 0;height:99%"
                            src="/img/pool-ambiente.png" />
                    </div>

                </div>
            </div>
        </footer>
    </div>



    <script type="text/javascript" src="https://www.lifegate.it/app/plugins/flying-pages/flying-pages.min.js?ver=2.4.6"
        id="flying-pages-js" defer></script>
    <script type="text/javascript" id="scriptloader-js-extra">
    /* <![CDATA[ */
    var tbm = {
        "ajaxurl": "https:\/\/www.lifegate.it\/wp\/wp-admin\/admin-ajax.php",
        "songurl": "https:\/\/servizi.lifegate.it\/titoli\/titoli.json"
    };
    /* ]]> */
    </script>
    <script type="text/javascript" src="https://www.lifegate.it/app/themes/lifegate-2020/dist/js/tbm.min.js?ver=1.95.3"
        id="scriptloader-js"></script>
    <script>
    tbm.respoinsesongtitle =
        "Ci dispiace, ma non abbiamo trovato nessun risultato utile. Prova ad impostare un altro orario.";
    tbm.photolabels = ['Foto ', ' di '];
    </script>
    <link rel="stylesheet" href="https://www.lifegate.it/app/themes/lifegate-2020/dist/css/afterall.min.css?ver=1.95.3"
        media="print" onload="this.media='all'">
</body>

</html>