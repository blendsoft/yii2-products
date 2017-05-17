<?php

use yii\widgets\Menu;

echo Menu::widget([
    'options' => ['class' => 'nav sidebar-menu'],    
    'linkTemplate' => '<a class="accordion-toggle" href="{url}"><span class="fa"></span><span class="sidebar-title">{label}</span><span class="caret"></span></a>',
    'submenuTemplate' => '<ul class="nav sub-nav">{items}</ul>',
    'items' => $tree,
    'activateParents' => true
]);
?>   

