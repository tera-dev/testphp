<?php
//include_once './classes/Connector.php';
include_once _MODELS_DIR_.'Territory.php';
include_once _HELPERS_DIR.'Url.php';



 ?>
<!--<input id="check" type="button"/>-->

<form method="POST" action="<?=Url::toRoute('user/create')?>">
    <div>
        <br/><br/>
        <input type="text" name="user[name]" class="user-data" placeholder="Введите ФИО">
        
    </div>
    
    <div>
        <br/><br/>
        <input type="email" name="user[email]" class="user-data" placeholder="Введите e-mail">
        
    </div>
    
    <div>
        <br/><br/>
        <select data-placeholder="Выберите область" class="chosen-select regions">
        <option></option>
        <?php foreach ($territoryItems as $item): ?>
            <option value="<?=$item->id?>"><?= $item->name?></option>
        <?php endforeach; ?>
        </select>
    </div>
   

    <div class="disabled">
        <br/><br/>
        <select data-placeholder="Выберите район или город" name="user[region_or_city]" class="regions-and-cities">
        </select>

    </div>
    
    <div class="disabled">
        <br/><br/>
        <select data-placeholder="Выберите поселок городского типа или село" name="user[urban-city_or_villiage]" 
                class="urban-cities-and-villages">
        </select>

    </div>

    <div class="disabled">
         <br/><br/>
         <select data-placeholder="Выберите село или район города" name="user[village_or_city-district]" class="villages-and-city-districts">
        </select>
    </div>
    
    <div class="disabled">
         <br/><br/>
         <select data-placeholder="Выберите посёлок" name="user[settlement]" class="settlements">
        </select>
    </div>

    <br/><br/>
    <input type="submit" value="Регистрация" class="sub">
</form>
<br/>
<span class="validation-tip empty-fields"></span>
<span class="validation-tip email"></span>

<script src="js/user/index.js"></script>
