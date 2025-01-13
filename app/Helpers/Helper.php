<?php

// use DOMDocument;
use App\Models\ProductStyle;
use App\Models\Vendor;
use App\Models\Product;

use App\Models\ProductClass;
use App\Models\PriceSegment;
use App\Models\ProductSubclass;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

function checkInFavourites($products)
{
    $favourites = Cart::instance('favourites')->content();
    if ($favourites->count() > 0) {
        foreach ($products as $product) {
            $res = $favourites->search(function ($cartItem, $key) use ($product) {
                return $cartItem->id === $product->id;
            });
            if ($res) {
                $product->inFavourites = 1;
            }
            // else {
            //     $product->inFavourites = 0;
            // }
        }
    }

    return $products;
}

function findVendorByOldCode($old_code)
{


    $vendor = Vendor::where('old_code', $old_code)->first();
    if ($vendor) {
        return $vendor->id;
    }
    return null;
}
function getFilter($querry, $request)
{
    if (filled($request->style)) {
        $querry->whereIn('product_style_id', $request->style);
    }
    if (filled($request->price)) {
        foreach ($request->price as $price) {
            $querry->whereRelation('vendor', 'price_segment_id', '=', $price);
        }
    }
    if (filled($request->category)) {

// TODO Категория или фильтр не работает
        // $category_ids = array();
        // $querry->whereIn('product_subtype_id', $request->category);
        $querry->whereIn('product_subtype_id', $request->category);
        // $querry->whereIn('filter_id', $request->category);
    }

    if (filled($request->filter)) {



        $querry->whereIn('filter_id', $request->filter);
    }

    if (filled($request->length_from) || filled($request->length_to) || filled($request->depth_from) || filled($request->depth_to) || filled($request->height_from) || filled($request->height_to)) {
        if (filled($request->length_from)) {
            $length_from = $request->length_from;
            $querry->whereHas('variant', function ($q) use ($length_from) {
                $q->where('length', '>', $length_from);
            });
        }
        if (filled($request->length_to)) {
            $length_to = $request->length_to;
            $querry->whereHas('variant', function ($q) use ($length_to) {
                $q->where('length', '<', $length_to);
            });
        }
        if (filled($request->depth_from)) {
            $depth_from = $request->depth_from;
            $querry->whereHas('variant', function ($q) use ($depth_from) {
                $q->where('width', '>', $depth_from);
            });
        }
        if (filled($request->depth_to)) {
            $depth_to = $request->depth_to;
            $querry->whereHas('variant', function ($q) use ($depth_to) {
                $q->where('width', '<', $depth_to);
            });
        }
        if (filled($request->height_from)) {
            $height_from = $request->height_from;
            $querry->whereHas('variant', function ($q) use ($height_from) {
                $q->where('height', '>', $height_from);
            });
        }
        if (filled($request->height_to)) {
            $height_to = $request->height_to;
            $querry->whereHas('variant', function ($q) use ($height_to) {
                $q->where('height', '<', $height_to);
            });
        }

    }
    return $querry;
}
function giveModelsArray()
{
    $product_classes    = array(); // ProductClass::get(array('id', 'name', 'old_code', 'product_type_id'))->toArray();
    $product_subclasses = array(); // ProductSubclass::get(array('id', 'name', 'old_code', 'product_class_id'))->toArray();
    $product_styles     = ProductStyle::get(array('id', 'name', 'old_code'))->toArray();
    $product_locations  = array();
    $price_segments     = PriceSegment::get(array('id', 'name', 'old_code'))->toArray();
    $vendors            = Vendor::get(array('id', 'name', 'old_code'))->toArray();
    // return array($product_classes, $product_styles, $product_locations, $price_segments, $vendors, $product_subclasses);
    return array(
        'product_classes' => $product_classes,
        'product_styles' => $product_styles,
        'product_locations' => $product_locations,
        'price_segments' => $price_segments,
        'vendors' => $vendors,
        'product_subclasses' => $product_subclasses,
    );

    // return array($product_classes, $product_styles, $product_locations, $price_segments, $vendors, $product_subclasses);


}
function findProductClassByOldCode($old_code)
{


    $vendor = ProductClass::where('old_code', $old_code)->first();
    if ($vendor) {
        return $vendor->id;
    }
    return null;
}
function findProductStyleByOldCode($old_code)
{
    $vendor = ProductStyle::where('old_code', $old_code)->first();
    if ($vendor) {
        return $vendor->id;
    }
    return null;
}

function findPriceSegmentByOldCode($old_code)
{
    $vendor = PriceSegment::where('old_code', $old_code)->first();
    if ($vendor) {
        return $vendor->id;
    }
    return null;
}

function file_get_contents_curl($url)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}
function downloadFile($imgName, $url, $path)
{
    $data = file_get_contents_curl($url);
    file_put_contents($path . $imgName, $data);
    echo "File downloaded!";

}

function firstLettersList($my_array)
{
    $result = array();
    foreach ($my_array as $v) {
        echo substr($v, 0, 1);
    }
}
function getResponsiveImagesList($model)
{
    $result = array();
}


//  ТЯЖКОЕ наследие царского режима
function FindValParam($p_name, $line, $rozd)
{
    $rez    = "";
    $line   = ' ~' . $line;
    $p_name = '~' . $p_name . '=';
    $poz    = stripos($line, $p_name);
    if ($poz > 0) {
        $rez = substr($line, $poz + 1, strlen($line) - $poz);
        $poz = stripos($rez, $rozd);
        if ($poz > 0)
            $rez = substr($rez, 0, $poz);
        $poz = stripos($rez, '=');
        if ($poz > 0)
            $rez = substr($rez, $poz + 1, strlen($rez) - $poz - 1);
    }
    $rez = str_replace(chr(1) . chr(1), ' ', $rez);
    return $rez;
}

function delete_pos($f_a, $f_p)
{
    $pos = strpos($f_a, $f_p);
    if ($pos !== false)
        $rr = substr_replace($f_a, "", 0, $pos + strlen($f_p));
    else
        $rr = $f_a;
    return $rr;
}
function GetImgList($dir, $nn = NULL)
{
    $fab = $dir;
    $ss  = "";
    for ($i = 0; $i < strlen($fab); $i++) {
        $a = $fab[$i];
        if ($a == "&")
            break;
        $ss = $ss . $a;
    }
    $fab = trim($ss);
    $ss  = "";
    for ($i = 0; $i < strlen($fab); $i++) {
        $a = $fab[$i];
        $a = mb_strtolower($a);
        if ($a == " ")
            $a = "_";
        if (($i > 1) and ($a == "."))
            $a = "";
        $ss = $ss . $a;
    }
    $dir = $ss;

    if (!(file_exists($dir)))
        return;

    $files = scandir($dir);
    $ok    = "0";
    $cc    = 0;
    foreach ($files as $entry) {
        if (
            (strpos(' ' . $entry, ".jpg") != 0) ||
            (strpos(' ' . $entry, ".jpeg") != 0) ||
            (strpos(' ' . $entry, ".png") != 0)
        ) {
            $ok = "1";
            $cc = $cc + 1;
            if (($nn == null) or (($nn != null) and ($cc <= $nn)))
                $rr[] = $dir . '/' . $entry;
            //    print($dir.'/'.$entry.'<br>');
        }
    }
    // print ( strval ( count ( $rr ) ).'<br>'.$ok.'<br>' ) ;

    if ($ok == "1")
        return $rr;
    //else return array("");
}
function aFindFile($f_namep)
{
    if (file_exists($f_namep) > 0) {
        return $f_namep;
    } else {
        $f_namep = '../' . $f_namep;
        if (file_exists($f_namep) > 0) {
            return $f_namep;
        }
    }
    return "*";
}
function file_to_array($f_name)
{
    $ff = aFindFile($f_name);
    if ($ff == "*") {
        $ff = aFindFile($f_name);
        // $ff = aFindFile('db/' . $f_name);

    }

    if ($ff == "*") {
        return array("");
    } else {
        return file($ff);
    }
}

function youtube_id_from_url($url)
{


    // обрежем таймкод
// ?t=
//   $url =stristr($url, '?t=' , true);
//   $ur2 =stristr($url, '&t=' , true);
// dd($url);
    $pos = strripos($url, '&t=');
    if (!$pos === false) {
        $url = stristr($url, '&t=', true);
    }
    $pos2 = strripos($url, '?t=');
    if (!$pos2 === false) {
        $url = stristr($url, '?t=', true);
    }
    // dd($url);

    $pattern =
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
    ;
    $result = preg_match($pattern, $url, $matches);
    if ($result) {
        return $matches[1];
    }
    return false;
}
function delete_small_images($images)
{
    $clear_arr = [];
    foreach (@$images as $image) {
        if (strpos($image, "_sml") === false) {

            array_push($clear_arr, $image);
        }
    }
    // dd($clear_arr);
    return $clear_arr;
}

/*
 *  LanguageHelper::pluralize(4, array('день', 'дня', 'дней'));
 */
function pluralize(int $n, array $variants)
{
    return $n % 10 == 1 && $n % 100 != 11 ? $variants[0] : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $variants[1] : $variants[2]);
}

function cut_link($url)
{
    $result = "";
    mb_internal_encoding("UTF-8");
    $url    = trim($url);
    $result = mb_substr($url, 2);
    $result = mb_substr($result, 0, -4);
    return $result;
}



function convert_bytes($size)
{
    $i = 0;
    while (floor($size / 1024) > 0) {
        ++$i;
        $size /= 1024;
    }

    $size = str_replace('.', ',', round($size, 1));

    switch ($i) {
        case 0:
            return $size .= ' байт';
        case 1:
            return $size .= ' КБ';
        case 2:
            return $size .= ' МБ';
    }
}

function format_bytes($bytes, $precision = 2)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow   = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}

function stripFile($in)
{
    $pieces = explode("/", $in); // split the URL by /
    if (count($pieces) < 4)
        return $in . "/";
    if (strpos(end($pieces), ".") !== false) { // we got a filename at the end
        array_pop($pieces); // remove the filename
    } elseif (end($pieces) !== "") { // it ends with a name without an extension, i.e. a directory
        $pieces[] = ""; // when $pieces is imploded, a "/" and then this "" will be appended
    }
    // else, already ends with a slash
    return implode("/", $pieces);
}
function checkAdnMakeSubfolder($gfg_folderpath)
{
    $gfg_folderpath = public_path($gfg_folderpath);

    echo "SUBFOLDER--" . $gfg_folderpath . "<br>";

    // CHECKING WHETHER PATH IS A DIRECTORY OR NOT
    if (is_dir($gfg_folderpath)) {
        // GETTING INTO DIRECTORY
        $files = opendir($gfg_folderpath); {
            // CHECKING FOR SMOOTH OPENING OF DIRECTORY
            if ($files) {
                //READING NAMES OF EACH ELEMENT INSIDE THE DIRECTORY
                while (($gfg_subfolder = readdir($files)) !== FALSE) {
                    // CHECKING FOR FILENAME ERRORS
                    if ($gfg_subfolder != '.' && $gfg_subfolder != '..') {
                        echo "SUBFOLDER--" . $gfg_subfolder . "<br>
                        " . "Files in " . $gfg_subfolder . "--<br>";

                        $dirpath = "GeeksForGeeks/" . $gfg_subfolder . "/";
                        // GETTING INSIDE EACH SUBFOLDERS
                        if (is_dir($dirpath)) {
                            $file = opendir($dirpath); {
                                if ($file) {
                                    //READING NAMES OF EACH FILE INSIDE SUBFOLDERS
                                    while (($gfg_filename = readdir($file)) !== FALSE) {
                                        if ($gfg_filename != '.' && $gfg_filename != '..') {
                                            echo $gfg_filename . "<br>";
                                        }
                                    }
                                }
                            }
                        }
                        echo "<br>";
                    }
                }
            }
        }
    }



}
function parsingInvalidHtml($html)
{
    $config = array(
        'clean' => 'yes',
        'output-html' => 'yes',
    );
    $tidy   = tidy_parse_string($html, $config, 'utf8');
    $tidy->cleanRepair();
    $dom = new DOMDocument;
    $dom->loadHTML($tidy);
    dd($tidy);
    return $dom;
}
function saveImagesFromDescription($html)
{
    $doc                      = new DOMDocument();
    $doc->strictErrorChecking = false;
    libxml_use_internal_errors(true);

    $doc->loadHTML($html);

    $images = $doc->getElementsByTagName('img');
    foreach ($images as $image) {
        echo $image->getAttribute('src') . "\n";
        echo $image->getAttribute('data-src') . "\n";

        $temp       = parse_url($image->getAttribute('data-src'));
        $img_folder = stripFile($temp['path']);


        if (!is_dir(public_path($img_folder))) {
            mkdir(public_path($img_folder), 0700, true);
        }

    }
}
