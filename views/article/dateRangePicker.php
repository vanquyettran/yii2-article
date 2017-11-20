<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 9/13/2017
 * Time: 9:53 AM
 */

$this->registerJsFile('//cdn.jsdelivr.net/momentjs/latest/moment.min.js');
$this->registerJsFile(
    '//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js',
    ['depends' => \yii\web\JqueryAsset::className()]
);
$this->registerCssFile(
    '//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css',
    ['depends' => \yii\bootstrap\BootstrapAsset::className()]
);
?>
    <script>
        <?php $this->beginBlock('daterangepicker') ?>
//        var glue = ' - ';
        var format = 'DD/MM/YYYY';
        $('<?= $selector ?>').each(function (index) {
//            var startDate = moment().format(format);
//            var endDate = moment().format(format);
//            var dateRange = $(this).val().split(glue);
//            if (2 == dateRange.length) {
//                startDate = dateRange[0];
//                endDate = dateRange[1];
//            }
            $(this).daterangepicker({
                    locale: {
                        format: format
                    }
//                    , startDate: startDate
//                    , endDate: endDate
//                    , ranges: {
//                        'Today': [moment(), moment().add(1, 'days')],
//                        'Yesterday': [moment().subtract(1, 'days'), moment()],
//                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
//                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
//                        'This Month': [moment().startOf('month'), moment().endOf('month')],
//                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
//                    }
//                    , showCustomRangeLabel: true
                }
//              , function(start, end, label) {
//                  alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
//              }
            );
            var form = (this).closest('form');
            if (form) {
                form.addEventListener("reset", function (event) {
                    $(this).val('');
                    $(this).attr('value', '');
                }.bind(this));
            }
        });
        <?php $this->endBlock() ?>
    </script>
<?php
$this->registerJs($this->blocks['daterangepicker'], \yii\web\View::POS_READY);
