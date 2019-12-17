<?php  require_once('php/helper.php'); ?>
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
    <!-- Tariffs -->
    <div class="container" v-if="allTariffsShow">
    <?php  foreach ($arData['tarifs'] as $key => $arTariffs): ?>
        <section class="tariff <?php element_translator($arTariffs['title']);?>">
            <div class="top">
                <h2 class="title">Тариф "<?php echo $arTariffs['title'];?>"</h2>
            </div>
            <div class="content">
                <div class="content_link" @click="tariffSelector(<?php echo $key;?>); allTariffsShow = false">
                    <div class="speed">
                        <span class="speed_count"><?php echo $arTariffs['speed'];?></span>
                        <span class="speed_measurement">Мбит/с</span>
                    </div>
                    <div class="price">
                        <span class="price_count"><?php print(price_range($arTariffs['tarifs']));?></span>
                        <span class="price_measurement">&#8381;/мес</span>
                    </div>
                    <?php if (isset($arTariffs['free_options'])):?>
                        
                        <div class="package">
                            <ul class="package_list">
                                <?php foreach ($arTariffs['free_options'] as $option):?>
                                    <li><?php echo $option;?></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <div class="bottom">
                <a href="<?php echo $arTariffs['link'];?>">узнать подробнее на сайте www.sknt.ru</a>
            </div>
        </section>
    <?php endforeach;?>
    </div>

    <!-- Variants -->
    <?php  foreach ($arData['tarifs'] as $key => $arTariffs): ?>
    <?php 
        $price_per_month_without_discount = 0;
    ?>
        <div class="container variants_container parameters_container" v-if="chosenTariff == <?php echo $key;?> && allVariantsShow">
            <header @click="chosenTariff = -1; allTariffsShow = true">
                <h2>Тариф "<?php echo $arTariffs['title'];?>"</h2>
            </header>
            <?php  foreach (array_sort($arTariffs['tarifs'], 'pay_period') as $subTariffKey => $subTariffVal): ?>
            <?php 
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
                    <h2 class="title"><?php print($pay_period . ' ' . rus_month_ending($pay_period));?></h2>
                </div>
                <div class="content">
                    <div class="content_link" @click="variantSelector(<?php echo $subTariffVal['ID'];?>); allVariantsShow = false">
                        <div class="price">
                            <span class="price_count"><?php echo $price_per_month;?></span>
                            <span class="price_measurement">&#8381;/мес</span>
                        </div>
                        <div class="package">
                            <ul class="package_list">
                                <li>разовый платёж &#8210; <span><?php echo $price_once;?></span> &#8381;</li>
                                <?php if ($pay_period != 1): ?>
                                    <li>скидка &#8210; <span><?php echo $discount;?></span> &#8381;</li>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <?php endforeach;?>
        </div>
    <?php endforeach;?>


    <!-- Parameters -->
    <?php  foreach ($arData['tarifs'] as $key => $arTariffs): ?>
        <?php  foreach (array_sort($arTariffs['tarifs'], 'pay_period') as $variantsKey => $variantsVal): ?>
            <?php 
                $pay_period = $variantsVal['pay_period'];
                $price_once =  $variantsVal['price'];
                $price_per_month = $price_once / $pay_period;
                $timestampAndTimezone = explode('+', $variantsVal['new_payday']);
                $active_to_date = gmdate("d.m.Y", ($timestampAndTimezone[0] + $timestampAndTimezone[1]));
            ?>
            <div class="container variants_container parameters_container" v-if="chosenVariant == <?php echo $variantsVal['ID'];?>">
                <header @click="chosenVariant = -1; allVariantsShow = true">
                    <h2>Выбор тарифа</h2>
                </header>
                <section class="tariff variants parameters" >
                    <div class="top">
                        <h2 class="title">Тариф "<?php echo $arTariffs['title'];?>"</h2>
                    </div>
                    <div class="content">
                        <div class="price">
                            <div>
                                <span class="pay_period_title">Период оплаты &#8210; </span>
                                <span class="pay_period_months"><?php print($pay_period . ' ' . rus_month_ending($pay_period));?></span>
                            </div>
                            <span class="price_count"><?php echo $price_per_month;?></span>
                            <span class="price_measurement">&#8381;/мес</span>
                        </div>
                        <div class="package">
                            <ul class="package_list">
                                <li>разовый платёж &#8210; <span><?php echo $price_once;?></span> &#8381;</li>
                                <li>со счёта спишется &#8210; <span><?php echo $price_once;?></span> &#8381;</li>
                            </ul>
                        </div>
                        <div class="period">
                            <ul class="period_list">
                                <li>вступит в силу &#8210; <span>сегодня</span></li>
                                <li>активно до &#8210; <span><?php echo $active_to_date;?></span></li>
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
        <?php endforeach;?>
    <?php endforeach;?>


</div>
</main>

<script src="js/vue.js"></script>
<script src="js/script.js"></script>


</body>
</html>