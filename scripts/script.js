var app = new Vue({
    el: '#app',
    data: {
        chosenTariff: -1,
        chosenVariant: -1,
        allTariffsShow: true,
        allVariantsShow: true,
        relocationConfirmed: false
    },
    methods: {
        tariffSelector: function(num) {
            this.chosenTariff = num;
        },
        variantSelector: function(num) {
            this.chosenVariant = num;
        },
        finalAction: function() {
            this.relocationConfirmed = confirm('Здесь подставляем в GET-запрос ID выбранного параметра и переходим на проверку адреса по ссылке www.sknt.ru/sorder.htm?tarif_type=internet&tarif_period_id=< ID >. К сожалению, ID параметров из json не совпадают с настоящими ID, поэтому, давайте хотя бы проверим адрес :)');
            if (this.relocationConfirmed) {
                window.location.href = "https://www.sknt.ru/sorder.htm?tarif_type=internet";
            }
        }
    }
})
