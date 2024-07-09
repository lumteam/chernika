$(document).ready(function() {
    var configForm = $('#form-podbor');

    function sendConfigForm(){
        $.post(window.location.pathname, configForm.serialize(), function( result ){
            if ( result == 'finish' )
                window.location.href = '/personal/cart/';
            else {
                configForm.html( $(result).find('#form-podbor').html() );
                $(".nice-select").niceSelect();
            }
        });
    }

    configForm.on('change', 'input', function(){
        sendConfigForm();
        return false;
    });

    configForm.on('click', '.js-type_elem', function(){
        configForm.find('[name="STEP"]').val(2);
        sendConfigForm();
    });

    configForm.on('click', '.js-type_elem_linses', function(){
        configForm.find('[name="STEP"]').val(4);
        sendConfigForm();
    });

    configForm.on('click', '.js-type_elem_linses_colors', function(){
        configForm.find('[name="STEP"]').val(5);
        sendConfigForm();
    });

    configForm.on('click', '.js-set_step', function() {
        configForm.find('[name="STEP"]').val( parseInt($(this).data('id')) );
        sendConfigForm();
        return false;
    });

    configForm.on('click', '.js-set_recept_enter', function(){
        var error = false;

        if ( configForm.find('[name="prizma"]').is(':checked') ) {
            if (
                configForm.find('[name="prizma_direction_right"]').val() == '' ||
                configForm.find('[name="prizma_power_right"]').val() == '' ||
                configForm.find('[name="prizma_direction_left"]').val() == '' ||
                configForm.find('[name="prizma_power_left"]').val() == ''
            ) {
                alert('Выберите значение вашей призмы');
                error = true;
            }
        }

        if ( !error ) {
            if ( configForm.find('[name="pd_63"]') && configForm.find('[name="pd_63"]').val() == ''  )
                alert('Выберите значение межзрачкового расстояния / PD');
            else if ( configForm.find('[name="pd_32_right"]') && configForm.find('[name="pd_32_right"]').val() == ''  )
                alert('Выберите значение межзрачкового расстояния / PD');
            else if ( configForm.find('[name="pd_32_left"]') && configForm.find('[name="pd_32_left"]').val() == ''  )
                alert('Выберите значение межзрачкового расстояния / PD');
            else if ( configForm.find('[name="recept"]') && configForm.find('[name="recept"]').val() == ''  )
                alert('Введите название рецепта');
            else if ( configForm.find('[name="agree" ]') && !configForm.find('[name="agree"]').is(':checked')  )
                alert('Подтвердите правильность заполнения данных');
            else {
                configForm.find('[name="STEP"]').val(3);
                sendConfigForm();
            }
        }
        return false;
    });

    configForm.on('click', '.js-type_elem_linses_colors', function(){
        configForm.find('[name="STEP"]').val(5);
        sendConfigForm();
    });
});