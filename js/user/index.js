
 //проверка массива на пустоту
    function isEmpty(obj) {
        for (let key in obj) {
          return false;
        }
        return true;
    }
  
    //загрузка городов и районов с селами в select
    function getCitiesAndRegions(per_id){
        $.get({
            url: Url.to('user/get-territories'),
            data:{
                'ter_pid':per_id
            },
            success: function(data) {
                let arr = JSON.parse(data);
                
                console.log(arr);
                if (!isEmpty(arr))  {
                                        
                    $select = $('select.regions-and-cities');
                    
                    $select.empty('option').
                            chosen("destroy").
                            prop('disabled', false).
                            append(`<option></option>`).
                            parent().removeClass('disabled');

                    arr.forEach(function(item) {
                        $select.append(`<option value=${item.id}-${item.terr_type}>${item.name}</option>`);
                    });

                    $select.addClass('chosen-select').chosen({no_results_text: "Город (район) не найден"});
                }

            }
        });
    }
     //загрузка пгт/сел/городов в select 
    function getUrbanCitiesAndVilliages(per_id){
        $.get({
            url:Url.to('user/get-territories'),
            data:{
                'ter_pid':per_id
            },
            success:function (data){
                let arr = JSON.parse(data);
                console.log(arr);
                if (!isEmpty(arr))  {
                    $select = $('select.urban-cities-and-villages');
                    
                    $select.empty('option').
                            chosen("destroy").
                            prop('disabled', false).
                            append(`<option></option>`).
                            parent().removeClass('disabled');
                    
                    arr.forEach(function(item) {
                        $select.append(`<option value=${item.id}>${item.name}</option>`);
                    });

                    $select.addClass('chosen-select').chosen({no_results_text: "Посёлок (село) не найден (-о)"});
                    
                }
            }
        });
    }
    

    //загрузка районов города и сел в select
    function getCityDistrictsAndVillages(per_id){
        $.get({
            url: Url.to('user/get-territories'),
            data:{
                'ter_pid':per_id
            },
            success: function(data) {
                var arr = JSON.parse(data);
                console.log(arr);
                if (!isEmpty(arr))  {
                    $select = $('select.villages-and-city-districts');
                    
                    $select.empty('option').
                            chosen("destroy").
                            prop('disabled', false).
                            append(`<option></option>`).
                            parent().removeClass('disabled');
                    
                    arr.forEach(function(item, i, arr) {
                        $select.append(`<option value=${item.id}>${item.name}</option>`);
                    });

                    $select.addClass('chosen-select').chosen({no_results_text: "Район (село) не найден (-о)"});
                }

            }
        });
    }
    
    //загрузка сел и поселков, которые входят в состав выбранного пгт/села в select
    function getSettlements(per_id){
        $.get({
            url: Url.to('user/get-territories'),
            data:{
                'ter_pid':per_id
            },
            success: function(data) {
                var arr = JSON.parse(data);
                console.log(arr);
                if (!isEmpty(arr))  {
                    $select = $('select.settlements');
                    
                    $select.empty('option').
                            chosen("destroy").
                            prop('disabled', false).
                            append(`<option></option>`).
                            parent().removeClass('disabled');
                    
                    arr.forEach(function(item, i, arr) {
                        $select.append(`<option value=${item.id}>${item.name}</option>`);
                    });

                    $select.addClass('chosen-select').chosen({no_results_text: "Район не найден"});
                }

            }
        });
    }
    
    $(window).on('load',function (){
        
        $('select.regions').chosen({no_results_text: "Область не найдена"});

        $('select.regions').on('change',function (){
            $this = $(this);
            
            //загрузка городов или сразу районов для областей (для Киева и Севастополя нужно сразу загружать районы)
            $('select.regions-and-cities, select.urban-cities-and-villages, select.villages-and-city-districts, select.settlements').
                        prop('disabled', true).parent().addClass('disabled');
            if ($this.val() == '8000000000' || $this.val() == '8500000000'){
                
                getCityDistrictsAndVillages($this.val());
            }
            getCitiesAndRegions($this.val());
        });
        
        $('select.regions-and-cities').on('change',function (){
            $this = $(this);
            //загрузка районов, в которых есть села и городов областного значение
            $('select.urban-cities-and-villages, select.villages-and-city-districts, select.settlements').
                        prop('disabled', true).parent().addClass('disabled');
            let ter_type = $this.val().split('-')[1];
            let ter_pid = $this.val().split('-')[0];
            if (ter_type === '1')  {
                //если выбран город, то загружаются его районы и села/пгт, которые входят в его состав
                getCityDistrictsAndVillages(ter_pid);
            }
            else{
                //если выбран район, то загружаются его села/пгт/города
                getUrbanCitiesAndVilliages(ter_pid);
            }
            
        });
        
        $('select.urban-cities-and-villages').on('change',function (){
            $this = $(this);
            //загрузка городов районного значения, пгт, сел
            $('select.villages-and-city-districts, select.settlements').
                        prop('disabled', true).parent().addClass('disabled');
            getCityDistrictsAndVillages($this.val());
        });
        
        $('select.villages-and-city-districts').on('change',function (){
            $this = $(this);
            //загрузка районов города обласного значения и сел, входящих в него
            $('select.settlements').prop('disabled', true).parent().addClass('disabled');
            getSettlements($this.val());
        });
        
        //валидация перед отправкой формы
        $('.sub').on('click',function (event){
            event.preventDefault();
            $('div').find('input.user-data, div.chosen-container-single').css('border','');
            $('span.validation-tip').html('');
            if (validate())  {
                $('form').trigger('submit');
            }
        });

        function validate(){
            //для select и input нужны разные селекторы  и уловия проверки 
            isValidated = true;
            $('form div').not('.disabled').find('div.chosen-container-single').each(function (){
               $this = $(this);
               if ($this.siblings('select').val() == '')  {
                   $this.css('border','2px solid red');
                   $('span.validation-tip.empty-fields').html('Не все поля заполнены.');
                   isValidated = false;
                }
            });
            
            $('form input.user-data').each(function (){

               $this = $(this);
               if ($(this).val() == '')  {
                   $(this).css('border','2px solid red');
                   $('span.validation-tip.empty-fields').html('Не все поля заполнены.');
                   isValidated = false;
                }
            });
            
            if ($('form input[type=email]').val().match(/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,5}$/) === null && 
                    $('form input[type=email]').val() !== '') {
                $('span.validation-tip.email').html(`Адрес электронной почты должен иметь вид <b>email@post.com</b> и содержать только латинские буквы`);
                isValidated = false;
            }  

            return isValidated;
        }
    });

