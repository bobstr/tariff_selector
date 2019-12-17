<?php

$jsonSrc = 'https://www.sknt.ru/job/frontend/data.json';
$jsonData = file_get_contents($jsonSrc);
$arData = json_decode($jsonData, true);


function element_translator($element) {
    $word = '';
    if (strpos($element, 'Вода') !== false ) {
        $word = 'water';
    } 
    else if (strpos($element, 'Огонь') !== false ) {
        $word = 'fire';
    }
    else if (strpos($element, 'Земля') !== false ) {
        $word = 'earth';
    }
    else {
        $word = 'element-missed';
    }
    echo $word;
}

function price_range($array) {
    $maxPrice = 0;
    $minPrice = 0;
    $payPeriod = 0;

    if(!isset($array[0]['price'])) {
        return '';
    } else {
        $arPrices = [];
        foreach($array as $item) {
            $arPrices[] = $item['price'] / $item['pay_period'];
        }
        $minPrice = min($arPrices);
        $maxPrice = max($arPrices);

        return $minPrice . ' &#8210; ' . $maxPrice;
    }
}

function rus_month_ending($num) {
    switch ($num) {
        case 1:
            return 'месяц';
        break;
        case 2:
        case 3:
        case 4:
            return 'месяца';
        break;
        case 5:
        case 6:
        case 7:
        case 8:
        case 9:
        case 10:
        case 11:
        case 12:
            return 'месяцев';
        break;
    }
}

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}