var config = {
  'language': 'en'
}

var client = window.navigator ? (window.navigator.language ||
  window.navigator.systemLanguage ||
  window.navigator.userLanguage) : (config.language + "-" + config.country);

var lng = (client.search('-') > 0) ?
  client.substring(0, client.search('-')).toLowerCase() :
  client.toLowerCase();

$(document).ready(function () {
    $('#automat').bind('click', function (e) {
        e.preventDefault();
        
        if($('#automat_searchkeywords').val() == '') console.log('Keywords empty');
            else var sk = $('#automat_searchkeywords').val();
            
        if($('#automat_location').val() == '') console.log('Location empty');
            else var loc = $('#automat_location').val();
        
        $.ajax({
            url: '/ajax/auto_portfolio',
            type:'post',
            data: {keywords: sk, location: loc},
            dataType: 'json',
            success: function (result) {
                $('#autoportfolio_result').html(result);
            }
        });
    });
});

$(document).ready(function () {
    $('#disable').bind('click', function (e) {
        e.preventDefault();
        
        $('#automat_searchkeywords').val('');
        $('#automat_location').val('');
        
        $.ajax({
            url: '/ajax/auto_portfolio_disable',
            type:'post',
            dataType: 'json',
            success: function (result) {
                $('#autoportfolio_result').html(result);
            }
        });
    });
});

$(document).ready(function () {
    $('button#save_user_about').bind('click', function (e) {
        e.preventDefault();
        
        $.ajax({
            url: '/ajax/save_user_about',
            type:'post',
            contentType: false,
            processData: false,
            data: new FormData($('#form_user_about').get(0)),
            dataType: 'json',
            cache: false,       
            success: function (result) {
                $('#ua_result').empty();
                $('.error_list_icon').remove();
                if(result.errors.length != 0) {
                    $.map(result.errors, function(i, item) {
                      $('#'+item).before('<p class="error_list_icon">' + i + '</p>');
                    });
                    
		            $("html, body").animate({scrollTop: $(".error_list_icon").offset().top - 90}, 800);
                } else {
                    $('#ua_result').html('<p class="addedSuccess">' + result.success + '</p>');
                }
            }
        });
    });
});

$(document).ready(function () {
    $('button#save_portfolio').bind('click', function (e) {
        e.preventDefault();
        
        $.ajax({
            url: '/ajax/saveportfolio',
            type:'post',
            contentType: false,
            processData: false,
            data: new FormData($('#saveuserportfolio').get(0)),
            dataType: 'json',
            cache: false,       
            success: function (result) {
                $('#ajax_result').empty();
                $('.error_list_icon').remove();
                if(result.errors.length != 0) {
                    $.map(result.errors, function(i, item) {
                      $('#'+item).before('<p class="error_list_icon">' + i + '</p>');
                    });
                    
		            $("html, body").animate({scrollTop: $(".error_list_icon").offset().top}, 800);
                } else {
                    $('#ajax_result').html('<p class="addedSuccess">' + result.success + '</p>');
                }
            }
        });
    });
});

$(document).ready(function () {
    $('button#education').bind('click', function (e) {
        e.preventDefault();
        
        $.ajax({                             
            url:'/ajax/'+$(this).attr('data-url'),
            type:'post',
            data: {
                id:                      $('input#id_education').val(),
                date_of_the_beginning:   $('input#date_of_the_beginning').val(),
                end_date:                $('input#end_date').val(),
                education_received:      $('input#education_received').val(),
                specialty:               $('input#specialty').val(),
                educational_institution: $('input#educational_institution').val(),
                primary_education:       $('#primary_education').val()
            },
            dataType: 'json',
            success: function (result) {
                $('p.error').remove();
                if(result.error) {
                    $.each(result.error, function(index, item) {
                        if(index == '0') $('#error_education').append('<p class="error">' + item + '</p>');
                        $('label[for='+index+']').append('<p class="error">' + item + '</p>');
                    });
                } else {
                    $('#error_education').remove();
                    $('#non_result').remove();
                    if($('button#education').attr('data-url') == 'NewEducation') {
                        $('#result_education .table').append('<tr id="'+result.success+'"><td id="td_date_of_the_beginning">' + $('#date_of_the_beginning').val() + '</td><td id="td_end_date">' + $('#end_date').val() + '</td><td id="td_education_received">' + $('#education_received').val() + '</td><td id="td_specialty">' + $('#specialty').val() + '</td><td id="td_educational_institution">' + $('#educational_institution').val() + '</td><td><a class="btn_edit" data="'+result.success+'" data-url="UPDEducation" title="Edit"><img src="/Media/martup/assets/images/icons/icon-edit.svg"></a> <a class="btn_remove" data="'+result.success+'" data-url="deleteEducation" title="Delete"><img src="/Media/martup/assets/images/icons/icon-trash.svg"></a></td></tr>');
                    } else {
                        $('#result_education .table tr#'+result.success).html('<td id="td_date_of_the_beginning">' + $('#date_of_the_beginning').val() + '</td><td id="td_end_date">' + $('#end_date').val() + '</td><td id="td_education_received">' + $('#education_received').val() + '</td><td id="td_specialty">' + $('#specialty').val() + '</td><td id="td_educational_institution">' + $('#educational_institution').val() + '</td><td><a class="btn_edit" data="'+result.success+'" data-url="UPDEducation" title="Edit"><img src="/Media/martup/assets/images/icons/icon-edit.svg"></a> <a class="btn_remove" data="'+result.success+'" data-url="deleteEducation" title="Delete"><img src="/Media/martup/assets/images/icons/icon-trash.svg"></a></td>');
                        $('button#education').attr('data-url', 'NewEducation');
                        $('button#education').html('<img src="/Media/martup/assets/images/icons/icons-add-45.png">');
                    }
                    
                    $('input#id_education').val('');
                    $('input#date_of_the_beginning').val('');
                    $('input#end_date').val('');
                    $('input#education_received').val('');
                    $('input#specialty').val('');
                    $('input#educational_institution').val('');
                }
            }
        });
    });

    $('button#save_category_potrfolio').bind('click', function (e) {
        e.preventDefault();
        
        $.ajax({                             
            url:'/ajax/'+$(this).attr('data-url'),
            type:'post',
            data: {
                id_category:    $('select#id_category').val(),
                portfolio_id:   $('input#portfolio_id').val()
            },
            dataType: 'json',
            success: function (r) {
                $('.error_list_icon').remove();
                if(r.errors.length != 0) {
                    $.map(r.errors, function(i, item) {
                      $('#'+item).before('<p class="error_list_icon">' + i + '</p>');
                    });
                } else {
                    $('#save_category_potrfolio').html('<p class="addedSuccess"><img src="/Media/martup/assets/images/icons/icon-thumbs-up.png" /> ' + r.success + '</p>');
                }
            }
        });
    });
    
    $('button#education_languages').bind('click', function (e) {
        e.preventDefault();
        
        $.ajax({                             
            url:'/ajax/'+$(this).attr('data-url'),
            type:'post',
            data: {
                title_lang:                $('#title_lang').val(),
                id:                        $('#id_education_languages').val(),
                knowledge_level_write:     $('#knowledge_level_write').val(),
                knowledge_level_read:      $('#knowledge_level_read').val(),
                knowledge_level_dialog:    $('#knowledge_level_dialog').val()
            },
            dataType: 'json',
            success: function (result) {
                $('p.error').remove();
                if(result.error) {
                    $.each(result.error, function(index, item) {
                        $('input[name='+index+']').before('<p class="error">' + item + '</p>');
                        $('select[name='+index+']').before('<p class="error">' + item + '</p>');
                    });
                } else {
                    $('#error_education_languages').remove();
                    $('#non_result_languages').remove();
                    if($('button#education_languages').attr('data-url') == 'NewEducation_languages') {
                        $('#result_education_languages .table').append('<tr id="'+result.success+'"><td id="td_title_lang">' + $('#title_lang').val() + '</td><td id="td_knowledge_level_write">' + $('#knowledge_level_write').val() + '</td><td id="td_knowledge_level_read">' + $('#knowledge_level_read').val() + '</td><td id="td_knowledge_level_dialog">' + $('#knowledge_level_dialog').val() + '</td><td><a class="btn_edit" data="'+result.success+'" data-url="UPDEducation_languages" title="Edit"><img src="/Media/martup/assets/images/icons/icon-edit.svg"></a> <a class="btn_remove" data="'+result.success+'" data-url="deleteEducation_languages" title="Delete"><img src="/Media/martup/assets/images/icons/icon-trash.svg"></a></td></tr>');
                    } else {
                        $('#result_education_languages .table tr#'+result.success).html('<td id="td_title_lang">' + $('#title_lang').val() + '</td><td id="td_knowledge_level_write">' + $('#knowledge_level_write').val() + '</td><td id="td_knowledge_level_read">' + $('#knowledge_level_read').val() + '</td><td id="td_knowledge_level_dialog">' + $('#knowledge_level_dialog').val() + '</td><td><a class="btn_edit" data="'+result.success+'" data-url="UPDEducation_languages" title="Edit"><img src="/Media/martup/assets/images/icons/icon-edit.svg"></a> <a class="btn_remove" data="'+result.success+'" data-url="deleteEducation_languages" title="Delete"><img src="/Media/martup/assets/images/icons/icon-trash.svg"></a></td>');
                        $('button#education_languages').attr('data-url', 'NewEducation_languages');
                        $('button#education_languages').html('<img src="/Media/martup/assets/images/icons/icons-add-45.png" />');
                    }
                    
                    $('#title_lang').val('');
                    $('#knowledge_level_write option[value=0]').prop('selected', true);
                    $('#knowledge_level_read option[value=0]').prop('selected', true);
                    $('#knowledge_level_dialog option[value=0]').prop('selected', true);
                }
            }
        });
    });
    
    $('button#education_computer').bind('click', function (e) {
        e.preventDefault();
        
        $.ajax({                             
            url:'/ajax/'+$(this).attr('data-url'),
            type:'post',
            data: {
                id:                      $('#id_education_computer').val(),
                title_lang_computer:     $('#title_lang_computer').val(),
                url_example:             $('#url_example').val(),
                level:                   $('#level').val()
            },
            dataType: 'json',
            success: function (result) {
                if(result.error) {
                    $('p.error').remove();
                    $.each(result.error, function(index, item) {
                        $('input[name='+index+']').before('<p class="error">' + item + '</p>');
                        $('select[name='+index+']').before('<p class="error">' + item + '</p>');
                    });
                } else {
                    $('#error_education_computer').remove();
                    $('#non_result_computer').remove();
                    if($('button#education_computer').attr('data-url') == 'NewEducation_computer') {
                        $('#result_education_computer .table').append('<tr id="'+result.success+'"><td id="td_title_lang_computer">' + $('#title_lang_computer').val() + '</td><td id="td_url_example">' + $('#url_example').val() + '</td><td id="td_level">' + $('#level').val() + '</td><td><a class="btn_edit" data="'+result.success+'" data-url="UPDEducation_computer" title="Edit"><img src="/Media/martup/assets/images/icons/icon-edit.svg"></a> <a class="btn_remove" data="'+result.success+'" data-url="deleteEducation_computer" title="Delete"><span class="ti-trash"></span></a></td></tr>');
                    } else {
                        $('#result_education_computer .table tr#'+result.success).html('<td id="td_title_lang_computer">' + $('#title_lang_computer').val() + '</td><td id="td_url_example">' + $('#url_example').val() + '</td><td id="td_level">' + $('#level').val() + '</td><td><a class="btn_edit" data="'+result.success+'" data-url="UPDEducation_computer" title="Edit"><img src="/Media/martup/assets/images/icons/icon-edit.svg"></a> <a class="btn_remove" data="'+result.success+'" data-url="deleteEducation_computer" title="Delete"><span class="ti-trash btn_remove"></span></a></td>');
                        $('button#education_computer').attr('data-url', 'NewEducation_computer');
                        $('button#education_computer').html('<img src="/Media/martup/assets/images/icons/icons-add-45.png">');
                    }
                    
                    $('#id_education_computer').val('');
                    $('#title_lang_computer').val('');
                    $('#url_example').val('');
                    $('#level option[value=0]').prop('selected', true);
                }
            }
        });
    });
    
    $('button#work_post').bind('click', function (e) {
        e.preventDefault();
        
        if ($('#real_work_post').is(':checked')) {
            var end_date_work = $('#real_work_post').attr('placeholder');
            var work_post = $('#real_work_post').attr('placeholder');
            var real_work_post = '1';
        } else {
            var end_date_work = $('#end_date_work').val();
            var work_post = $('#end_date_work').val();
            var real_work_post = '0';
        }
                        
        $.ajax({                             
            url:'/ajax/'+$(this).attr('data-url'),
            type:'post',
            data: {
                id:                      $('#id_work_post').val(),
                date_of_the_beginning_work:   $('#date_of_the_beginning_work').val(),
                end_date_work:           end_date_work,
                real_work_post:          real_work_post,
                work_post_fact:          $('#work_post_fact').val(),
                position:                $('#position').val()
            },
            dataType: 'json',
            success: function (result) {
                $('p.error').remove();
                if(result.error) {
                    $.each(result.error, function(index, item) {
                        if(index == '0') $('#error_work_post').append('<p class="error">' + item + '</p>');
                        $('label[for='+index+']').append('<p class="error">' + item + '</p>');
                    });
                } else {
                    $('#error_work_post').remove();
                    $('#non_result_work_post').remove();
                    
                    if($('button#work_post').attr('data-url') == 'NewWork_post') {
                        $('#result_work_post .table').append('<tr id="'+result.success+'"><td id="td_date_of_the_beginning_work">' + $('#date_of_the_beginning_work').val() + '</td><td id="td_end_date_work">' + work_post + '</td><td id="td_work_post_fact">' + $('#work_post_fact').val() + '</td><td id="td_position">' + $('#position').val() + '</td><td><a class="btn_edit" data="'+result.success+'" data-url="UPDWork_post" title="Edit"><img src="/Media/martup/assets/images/icons/icon-edit.svg"></a> <a class="btn_remove" data="'+result.success+'" data-url="deleteWork_post" title="Delete"><img src="/Media/martup/assets/images/icons/icon-trash.svg" /></a></td></tr>');
                    } else {
                        $('#result_work_post .table tr#'+result.success).html('<td id="td_date_of_the_beginning_work">' + $('#date_of_the_beginning_work').val() + '</td><td id="td_end_date_work">' + work_post + '</td><td id="td_work_post_fact">' + $('#work_post_fact').val() + '</td><td id="td_position">' + $('#position').val() + '</td><td><a class="btn_edit" data="'+result.success+'" data-url="UPDWork_post" title="Edit"><img src="/Media/martup/assets/images/icons/icon-edit.svg"></a> <a class="btn_remove" data="'+result.success+'" data-url="deleteWork_post" title="Delete"><img src="/Media/martup/assets/images/icons/icon-trash.svg" /></a></td>');
                        $('button#work_post').attr('data-url', 'NewWork_post');
                        $('button#work_post').html('<img src="/Media/martup/assets/images/icons/icons-add-45.png" />');
                    }
                    
                    $('#id_work_post').val('');
                    $('#date_of_the_beginning_work').val('');
                    $('#end_date_work').val('');
                    $('#real_work_post').val('');
                    $('#work_post_fact').val('');
                    $('#position').val('');
                }
            }
        });
    });
});

$(function() {
    $(document).on('click', '.btn_remove', function (e) {
        e.preventDefault();
        var url = $(this).attr('data-url');
        var tr = 'tr#'+$(this).attr('data');
        $.ajax({
            url:'/ajax/'+url,
            type:'post',
            data: {
                id: $(this).attr('data')
            },
            dataType: 'text',
            success: function (result) {
                if(result == 'true') {
                    $('#error').remove();
                    $('#non_result').remove();
                    $(tr).remove();
                    $('button#education').attr('data-url', 'NewEducation');
                    $('button#education').html('<img src="/Media/martup/assets/images/icons/icons-add-45.png">');
                    $('button#education_languages').attr('data-url', 'NewEducation_languages');
                    $('button#education_languages').html('<img src="/Media/martup/assets/images/icons/icons-add-45.png">');
                    $('button#education_computer').attr('data-url', 'NewEducation_computer');
                    $('button#education_computer').html('<img src="/Media/martup/assets/images/icons/icons-add-45.png">');
                    $('button#work_post').attr('data-url', 'NewWork_post');
                    $('button#work_post').html('<img src="/Media/martup/assets/images/icons/icons-add-45.png">');
                    
                    if ($("#clear_fields_education").length != 0) {
                        $("#clear_fields_education").remove();
                    }
                    
                    if ($("#clear_fields_education_languages").length != 0) {
                        $("#clear_fields_education_languages").remove();
                    }
                    
                    if ($("#clear_fields_education_computer").length != 0) {
                        $("#clear_fields_education_computer").remove();
                    }
                    
                    if ($("#clear_fields_work_post").length != 0) {
                        $("#clear_fields_work_post").remove();
                    }
                }
            }                          
        });            
    });
});

$(function() {
    $(document).on('click', '.btn_edit', function (e) {
        e.preventDefault();
        var url = $(this).attr('data-url');
        
        if(url == 'UPDEducation') {
            $('button#education').attr('data-url', 'UPDEducation');
            $('button#education').html('<img src="/Media/martup/assets/images/icons/icons-save-45.png">');
            
            if ($("#clear_fields_education").length == 0) {
                $('<button/>', {
                    html: '<img src="/Media/martup/assets/images/icons/icons-undo-45.png">',
                    id: 'clear_fields_education',
                    class: 'clear_fields pull-right'
                }).appendTo('#legend_education');
            }
            
            $('input#id_education').val($(this).attr('data'));
            $('input#date_of_the_beginning').val($('#'+$(this).attr('data')+' #td_date_of_the_beginning').text());
            $('input#end_date').val($('#'+$(this).attr('data')+' #td_end_date').text());
            $('input#education_received').val($('#'+$(this).attr('data')+' #td_education_received').text());
            $('input#specialty').val($('#'+$(this).attr('data')+' #td_specialty').text());
            $('input#educational_institution').val($('#'+$(this).attr('data')+' #td_educational_institution').text());
        }
        
        if(url == 'UPDEducation_languages') {
            $('button#education_languages').attr('data-url', 'UPDEducation_languages');
            $('button#education_languages').html('<img src="/Media/martup/assets/images/icons/icons-save-45.png">');
            
            if ($("#clear_fields_languages").length == 0) {
                $('<button/>', {
                    html: '<img src="/Media/martup/assets/images/icons/icons-undo-45.png">',
                    id: 'clear_fields_languages',
                    class: 'clear_fields pull-right'
                }).appendTo('#legend_education_languages');
            }
            
            $('input#id_education_languages').val($(this).attr('data'));
            $('input#title_lang').val($('#'+$(this).attr('data')+' #td_title_lang').text());
            $('#knowledge_level_write option[value='+$('#'+$(this).attr('data')+' #td_knowledge_level_write').text()+']').prop('selected', true);
            $('#knowledge_level_read option[value='+$('#'+$(this).attr('data')+' #td_knowledge_level_read').text()+']').prop('selected', true);
            $('#knowledge_level_dialog option[value='+$('#'+$(this).attr('data')+' #td_knowledge_level_dialog').text()+']').prop('selected', true);
        }
        
        if(url == 'UPDEducation_computer') {
            $('button#education_computer').attr('data-url', 'UPDEducation_computer');
            $('button#education_computer').html('<img src="/Media/martup/assets/images/icons/icons-save-45.png">');
            
            if ($("#clear_fields_computer").length == 0) {
                $('<button/>', {
                    html: '<img src="/Media/martup/assets/images/icons/icons-undo-45.png">',
                    id: 'clear_fields_computer',
                    class: 'clear_fields pull-right'
                }).appendTo('#legend_education_computer');
            }
            
            $('input#id_education_computer').val($(this).attr('data'));
            $('input#title_lang_computer').val($('#'+$(this).attr('data')+' #td_title_lang_computer').text());
            $('input#url_example').val($('#'+$(this).attr('data')+' #td_url_example').text());
            $('#level option[value='+$('#'+$(this).attr('data')+' #td_level').text()+']').prop('selected', true);
        }
        
        if(url == 'UPDWork_post') {
            $('button#work_post').attr('data-url', 'UPDWork_post');
            $('button#work_post').html('<img src="/Media/martup/assets/images/icons/icons-save-45.png">');
            
            if ($("#clear_fields_work_post").length == 0) {
                $('<button/>', {
                    html: '<img src="/Media/martup/assets/images/icons/icons-undo-45.png">',
                    id: 'clear_fields_work_post',
                    class: 'clear_fields pull-right'
                }).appendTo('#legend_work_post');
            }
            
            $('input#id_work_post').val($(this).attr('data'));
            $('input#date_of_the_beginning_work').val($('#'+$(this).attr('data')+' #td_date_of_the_beginning_work').text());
            $('input#work_post_fact').val($('#'+$(this).attr('data')+' #td_work_post_fact').text());
            $('#real_work_post').val(),
            $('input#end_date_work').val($('#'+$(this).attr('data')+' #td_end_date_work').text());
            $('input#position').val($('#'+$(this).attr('data')+' #td_position').text());
        }
    });
});

$(function() {
    $(document).on('click', '#clear_fields_education', function (e) {
        e.preventDefault();
        
        $('button#education').attr('data-url', 'NewEducation');
        $('button#education').html('<img src="/Media/martup/assets/images/icons/icons-add-45.png" />');
        
        $('input#id_education').val('');
        $('input#date_of_the_beginning').val('');
        $('input#end_date').val('');
        $('input#education_received').val('');
        $('input#specialty').val('');
        $('input#educational_institution').val('');
        
        $('#clear_fields_education').remove();
    });
});

$(function() {
    $(document).on('click', '#clear_fields_languages', function (e) {
        e.preventDefault();
        
        $('button#education_languages').attr('data-url', 'NewEducation_languages');
        $('button#education_languages').text('<img src="/Media/martup/assets/images/icons/icons-add-45.png" />');
        
        $('input#id_education_languages').val('');
        $('input#title_lang').val('');
        $('#knowledge_level_write option[value=0]').prop('selected', true);
        $('#knowledge_level_read option[value=0]').prop('selected', true);
        $('#knowledge_level_dialog option[value=0]').prop('selected', true);
        
        $('#clear_fields_languages').remove();
    });
});

$(function() {
    $(document).on('click', '#clear_fields_computer', function (e) {
        e.preventDefault();
        
        $('button#education_computer').attr('data-url', 'NewEducation_computer');
        $('button#education_computer').text('<img src="/Media/martup/assets/images/icons/icons-add-45.png" />');
        
        $('input#id_education_computer').val('');
        $('input#title_lang_computer').val('');
        $('input#url_example').val('');
        $('#level option[value=0]').prop('selected', true);
        
        $('#clear_fields_computer').remove();
    });
});

$(function() {
    $(document).on('click', '#clear_fields_work_post', function (e) {
        e.preventDefault();
        
        $('button#work_post').attr('data-url', 'NewWork_post');
        $('button#work_post').html('<img src="/Media/martup/assets/images/icons/icons-add-45.png" />');
        
        $('input#id_work_post').val('');
        $('input#date_of_the_beginning_work').val('');
        $('input#work_post_fact').val('');
        $('input#end_date_work').val('');
        $('input#real_work_post').val(''),
        $('input#position').val('');
        
        $('#clear_fields_work_post').remove();
    });
});

$(function () {
    $('.daterangepicker_birthDate').datetimepicker({
        locale: lng,
        format: "DD.MM.YYYY"
    });
    
    $('.daterangepicker_beginning').datetimepicker({
        locale: lng,
        format: "DD.MM.YYYY"
    });
    $('.daterangepicker_end').datetimepicker({
        useCurrent: false,
        locale: lng,
        format: "DD.MM.YYYY"
    });
    $(".daterangepicker_beginning").on("dp.change", function (e) {
        $('.daterangepicker_end').data("DateTimePicker").minDate(e.date);
    });
    $(".daterangepicker_end").on("dp.change", function (e) {
        $('.daterangepicker_beginning').data("DateTimePicker").maxDate(e.date);
    });
    
    $('.daterangepicker_beginning_work').datetimepicker({
        locale: lng,
        format: "DD.MM.YYYY"
    });
    $('.daterangepicker_end_work').datetimepicker({
        useCurrent: false,
        locale: lng,
        format: "DD.MM.YYYY"
    });
    $("daterangepicker_beginning_work").on("dp.change", function (e) {
        $('daterangepicker_end_work').data("DateTimePicker").minDate(e.date);
    });
    $("daterangepicker_end_work").on("dp.change", function (e) {
        $('daterangepicker_beginning_work').data("DateTimePicker").maxDate(e.date);
    });
});