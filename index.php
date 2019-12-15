<? require_once('php/helper.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/reset.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <title>SkyNet's test task (tariffs)</title>
</head>
<body>
<main>
<div id="app">
    <div class="container" v-if="allTariffsShow">
    <!-- Tariffs -->
    <? foreach ($arData['tarifs'] as $key => $arTariffs): ?>
        <section class="tariff <?=element_translator($arTariffs['title']);?>">
            <div class="top">
                <h2 class="title">Тариф "<?=$arTariffs['title']?>"</h2>
            </div>
            <div class="content">
                <div class="content_link" @click="tariffSelector(<?=$key?>); allTariffsShow = false">
                    <div class="speed">
                        <span class="speed_count"><?=$arTariffs['speed']?></span>
                        <span class="speed_measurement">Мбит/с</span>
                    </div>
                    <div class="price">
                        <span class="price_count"><?=price_range($arTariffs['tarifs'])?></span>
                        <span class="price_measurement">&#8381/мес</span>
                    </div>
                    <?if (isset($arTariffs['free_options'])):?>
                        
                        <div class="package">
                            <ul class="package_list">
                                <?foreach ($arTariffs['free_options'] as $option):?>
                                    <li><?=$option;?></li>
                                <?endforeach;?>
                            </ul>
                        </div>
                    <?endif;?>
                </div>
            </div>
            <div class="bottom">
                <a href="<?=$arTariffs['link']?>">узнать подробнее на сайте www.sknt.ru</a>
            </div>
        </section>
    <?endforeach;?>
    </div>
    <!-- /Tariffs -->

    <!-- Variants -->
    <? foreach ($arData['tarifs'] as $key => $arTariffs): ?>
    <?
        $price_per_month_without_discount = 0;
    ?>
        <div class="container variants_container parameters_container" v-if="chosenTariff == <?=$key?> && allVariantsShow">
            <header @click="chosenTariff = -1; allTariffsShow = true">
                <h2>Тариф "<?=$arTariffs['title'];?>"</h2>
            </header>
            <? foreach (array_sort($arTariffs['tarifs'], 'pay_period') as $subTariffKey => $subTariffVal): ?>
            <?
                $pay_period = $subTariffVal['pay_period'];
                $price_once =  $subTariffVal['price'];
                $price_per_month = $price_once / $pay_period;
                $discount = $price_per_month_without_discount * $pay_period - $price_once;
                if ($pay_period == 1) {
                    $price_per_month_without_discount = $price_once;
                }
            ?>
            <section class="tariff variants">
                <div class="top">
                    <h2 class="title"><?=($pay_period . ' ' . rus_month_ending($pay_period))?></h2>
                </div>
                <div class="content">
                    <div class="content_link" @click="variantSelector(<?=$subTariffVal['ID']?>); allVariantsShow = false">
                        <div class="price">
                            <span class="price_count"><?=$price_per_month;?></span>
                            <span class="price_measurement">&#8381/мес</span>
                        </div>
                        <div class="package">
                            <ul class="package_list">
                                <li>разовый платёж &#8210; <span><?=$price_once;?></span> &#8381</li>
                                <?if ($pay_period != 1): ?>
                                    <li>скидка &#8210; <span><?=$discount;?></span> &#8381</li>
                                <?endif;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <?endforeach;?>
        </div>
    <?endforeach;?>
    <!-- /Variants -->

    <!-- Parameters -->
    <? foreach ($arData['tarifs'] as $key => $arTariffs): ?>
        <? foreach (array_sort($arTariffs['tarifs'], 'pay_period') as $variantsKey => $variantsVal): ?>
            <?
                $pay_period = $variantsVal['pay_period'];
                $price_once =  $variantsVal['price'];
                $price_per_month = $price_once / $pay_period;
                $timestampAndTimezone = explode('+', $variantsVal['new_payday']);
                $active_to_date = gmdate("d.m.Y", ($timestampAndTimezone[0] + $timestampAndTimezone[1]));
            ?>
            <div class="container variants_container parameters_container" v-if="chosenVariant == <?=$variantsVal['ID']?>">
                <header @click="chosenVariant = -1; allVariantsShow = true">
                    <h2>Выбор тарифа</h2>
                </header>
                <section class="tariff variants parameters" >
                    <div class="top">
                        <h2 class="title">Тариф "<?=$arTariffs['title'];?>"</h2>
                    </div>
                    <div class="content">
                        <div class="price">
                            <div>
                                <span class="pay_period_title">Период оплаты &#8210; </span>
                                <span class="pay_period_months"><?=($pay_period . ' ' . rus_month_ending($pay_period))?></span>
                            </div>
                            <span class="price_count"><?=$price_per_month?></span>
                            <span class="price_measurement">&#8381/мес</span>
                        </div>
                        <div class="package">
                            <ul class="package_list">
                                <li>разовый платёж &#8210; <span><?=$price_once?></span> &#8381</li>
                                <li>со счёта спишется &#8210; <span><?=$price_once?></span> &#8381</li>
                            </ul>
                        </div>
                        <div class="period">
                            <ul class="period_list">
                                <li>вступит в силу &#8210; <span>сегодня</span></li>
                                <li>активно до &#8210; <span><?=$active_to_date;?></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="bottom">
                        <button 
                            type="button" 
                            class="bottom_button" 
                            @click="finalAction">Выбрать
                        </button>
                    </div>
                </section>
            </div>
        <?endforeach;?>
    <?endforeach;?>
    <!-- /Parameters -->

</div>
</main>

<script src="js/vue.js"></script>
<script src="js/script.js"></script>


</body>
</html>