<?php

use yii\bootstrap4\Html;

?>
<!-- FOOTER -->
<footer id="footer">
    <!-- top footer -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-5 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title"><?= Yii::t('app', 'About Us') ?></h3>
                        <p><?= Yii::t('app', 'Web Development Programmer') ?> </p>
                        <ul class="footer-links">
                            <li><?= Html::a('<i class="fa fa-map-marker"></i>' . Yii::t('app', '1734 Germany'), ['']) ?></a></li>
                            <li><?= Html::a('<i class="fa fa-phone"></i>' . Yii::t('app', '+49 157'), ['']) ?></a></li>
                            <li><?= Html::a('<i class="fa fa-envelope-o"></i>' . Yii::t('app', 'jelany.kattan@hotmail.com'), ['']) ?></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 col-xs-8">
                    <div class="footer">
                        <h3 class="footer-title"><?= Yii::t('app', 'Our projects') ?></h3>
                        <ul class="footer-links">
                            <li><?= Html::a(Yii::t('app', 'Market Backend'), ['']) ?></a></li>
                            <li><?= Html::a(Yii::t('app', 'Market Frontend'), ['']) ?></a></li>
                            <li><?= Html::a(Yii::t('app', 'Book Gallery Backend'), ['']) ?></a></li>
                            <li><?= Html::a(Yii::t('app', 'Book Gallery Frontend'), ['']) ?></a></li>
                        </ul>
                    </div>
                </div>

                <div class="clearfix visible-xs"></div>

                <div class="col-md-3 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title"><?= Yii::t('app', 'programmings language') ?></h3>
                        <ul class="footer-links">
                            <li><?= Html::a(Yii::t('app', 'Yii2 Framework'), ['']) ?></a></li>
                            <li><?= Html::a(Yii::t('app', 'Mysql'), ['']) ?></a></li>
                            <li><?= Html::a(Yii::t('app', 'PHP'), ['']) ?></a></li>
                            <li><?= Html::a(Yii::t('app', 'JS'), ['']) ?></a></li>
                        </ul>
                    </div>
                </div>

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /top footer -->
</footer>
<!-- /FOOTER -->