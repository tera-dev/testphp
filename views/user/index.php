<?php
//include_once './classes/Connector.php';
include_once _MODELS_DIR_.'Territory.php';



 ?>

<form method="POST" action="index.php?r=user/create">
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
            <option value='<?=$item->getId()?>'><?= $item->getName() ?></option>
        <?php endforeach; ?>
        </select>
    </div>
   

    <div class="cities disabled">
        <br/><br/>
        <select data-placeholder="Выберите город" name="user[city]" class="cities">
        </select>

    </div>

    <div class="districts disabled">
         <br/><br/>
         <select data-placeholder="Выберите район" name="user[district]" class="districts">
        </select>
    </div>

    <br/><br/>
    <input type="submit" value="Регистрация" class="sub">
</form>
<br/>
<span class="validation-tip"></span>

<script>
    
    function isEmpty(obj) {
        for (let key in obj) {
          return false;
        }
        return true;
    }
  
    function getCities(per_id){
        $.get({
            url: 'http://testphp/index.php?r=user/get-territories',
            data:{
                'ter_pid':per_id,
                'ter_type_id':'1'
            },
            success: function(data) {
                var arr = JSON.parse(data);
                if (!isEmpty(arr))  {

                    $('select.cities').parent().removeClass('disabled');
                    $('select.cities').empty('option').chosen("destroy").append(`<option></option>`);
                    console.log(arr);
                    arr.forEach(function(item, i, arr) {

                    $('select.cities').append(`<option value=${item.id}>${item.name}</option>`);
                    });

                    $('select.cities').addClass('chosen-select').chosen({no_results_text: "Город не найден"});
                }

            }
        });
    }
  
    function getDistr(per_id){
        $.get({
            url: 'http://testphp/index.php?r=user/get-territories',
            data:{
                'ter_pid':per_id,
                'ter_type_id':'3'
            },
            success: function(data) {
                var arr = JSON.parse(data);
                if (!isEmpty(arr))  {
                    $('select.districts').prop("disabled", false);

                    console.log(arr);
                    $('select.districts').parent().removeClass('disabled');
                    $('select.districts').empty('option').chosen("destroy").append(`<option></option>`);
                    arr.forEach(function(item, i, arr) {
//                            console.log(item.id + " " + item.name);
                    $('select.districts').append(`<option value=${item.id}>${item.name}</option>`);
                    });

                    $('select.districts').addClass('chosen-select').chosen({no_results_text: "Город не найден"});
                }
                else{
                    $('select.districts').prop("disabled", true).parent().addClass('disabled');
                }

            }
        });
    }
    $(window).on('load',function (){
        $('.regions.chosen-select').chosen({no_results_text: "Область не найдена"});

        $('button').on('click', function() {
                $.get({
                    url: 'http://testphp/index.php?r=user/get-territories',
                    data:{
                        'ter_pid':'0500000000',
                        'ter_type_id':'1'
                    },
                    success: function(data) {
                        console.log(JSON.parse(data));
                    }
                });
        });
        
        $('select.regions').on('change',function (){
            $this = $(this);
            if ($this.val() == '8000000000' || $this.val() == '8500000000'){
                $('select.cities').parent().addClass('disabled');
                getDistr($this.val());
            }
            getCities($this.val());
        });
        
        $('select.cities').on('change',function (){
            $this = $(this);
            
            getDistr($this.val());
        });
        
        
        $('.sub').on('click',function (event){
            event.preventDefault();
            $('div').find('input.user-data, div.chosen-container-single').
                    css('border','');
            $('span.validation-tip').html('');
            if (validate())  {
 
                $('form').trigger('submit');
            }
            else{
                $('span.validation-tip').html('Не все поля заполнены.');
            }

        });
        
        function validate(){
            
            isValidated = true;
            $('form div').not('.disabled').find('div.chosen-container-single').each(function (){
               $this = $(this);
               if ($this.siblings('select').val() == '')  {
                   $this.css('border','2px solid red');
                   console.log('select false;');
                   isValidated = false;
                }
            });
            
            $('form input.user-data').each(function (){
                console.log($(this));
               $this = $(this);
               if ($(this).val() == '')  {
                   $(this).css('border','1px solid red');
                   isValidated = false;
                }
            });
            console.log(isValidated);
            return isValidated;
        }
    });

    
</script>
