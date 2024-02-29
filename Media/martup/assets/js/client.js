$(function () {
    var user_login = $('#favorit').attr('data');
    var usersChatList = $('#usersChatList');
    var chatBox = $('#chatBox');
    
    var usersDataInChatList = {};
    
    var dataTime = new Date();
    
    const incommingmsg = new Howl({
        src: ['/Media/images/msgSound/incommingmsg.mp3'],
        volume: 0.3
    });
    
    const userOffline = new Howl({
        src: ['/Media/images/msgSound/userOffline.mp3'],
        volume: 0.3
    });
    
    const userOnline = new Howl({
        src: ['/Media/images/msgSound/userOnline.mp3'],
        volume: 0.3
    });
    
    var incommingmsgPlay;
    incommingmsg.onend = () => incommingmsgPlay = false; // когда доиграл, сбрасываем id
    
    
    var userOfflinePlay;
    userOffline.onend = () => userOfflinePlay = false;
    
    var userOnlinePlay;
    userOnline.onend = () => userOnlinePlay = false;
    
    //подключение к серверу
    const socket = io("https://findsol.it:3000");
    
    socket.on('connect', function (){//подключение к серверу
        /*---------------LOGIN USER, ADD BTNONLINE, DISCONNECT USER, DELETE BTNONLINE-----------*/
        socket.emit('login', user_login); //отправляем id авторизованного атвтора
        
        socket.on('createBtnChat', function (data) { //принимаем ответ от сервера и создаем кнопку online в списке чата если ее нет
            if(!$("div").is('.userOnline[data="'+data.id+'"]')) {
                $('#message[data="'+data.id+'"]').append('<div class="userOnline" data="'+data.id+'">online</div>');
                
                /*if($('#noSound').attr('data') === '1') {
                    if (userOfflinePlay) userOffline.stop(userOfflinePlay); // ещё играет - остановим
                    userOfflinePlay = userOffline.play(); // играть сначала
                }*/
            }
            
            if(data.id == $('div#online').attr('val')) {
                BtnCreateChat(data.id, data.login);
            }
        });
        
        if($("div").is('#online')) { // если есть div с id online
            socket.emit('ifAuthorOnline', $('div#online').attr('val'));
        }
        
        socket.on('deleteBtnChat', function(id){
            $('#createChat_'+id).remove();
            $('.userOnline[data="'+id+'"]').remove();
        });
        /*---------------/LOGIN USER, ADD BTNONLINE, DISCONNECT USER, DELETE BTNONLINE-----------*/
        
        
        
        
        
        /*-----START CHAT-----*/
        /*-----CREATE USERS LIST-----*/
        $(document).on('click','.createChat', function(e){
            if($('#online').attr('val') !== user_login) {
                socket.emit('startchat', $('#online').attr('val'));
            } else return false;
        });
        
        socket.on('createUsersList', function(usersList) {
            usersChatList.empty();
            
            $.each(usersList,function(index, value){
                if (value['onlineSatus'] == '1') var css = '<div class="userOnline" data="'+value['id']+'"></div>';
                if (value['onlineSatus'] == '0') var css = '';
                
                if (value['numNewMsg'] > 0) var newMsg = '<div class="numNewMsg" data="'+value['id']+'">+'+value['numNewMsg']+'</div>';
                if (value['numNewMsg'] == '0') var newMsg = '';
                
                if (value['user_img'] == null) var user_img = 'Media/images/no_avatar.png';
                else var user_img = value['user_img'];
                
                if($('.userMsgList[data="'+value['id']+'"]').length === 0) {
                    usersChatList.append('<div class="userMsgList" id="message" data="'+value['id']+'">'+
                                            '<img src="/'+ user_img +'" title="'+value['login']+'" />'+
                                            '<div class="menuUser">'+
                                                '<button class="btndltusr" title="Delete '+value['login']+'" id="btndltusr" data = "' + value['id'] + '"><img src="/Media/martup/assets/images/icons/icon-trash.svg" style="height: 16px; width: 16px;" alt=""></button>'+
                                                '<button class="btnclose" title="Hide '+value['login']+'" id="closechat" data = "' + value['id'] + '"><img src="/Media/martup/assets/images/icons/icons8-unpin-16.png" style="height: 16px; width: 16px;" alt=""></button>'+
                                                '<button class="banUser" title="Banned '+value['login']+'" data = "' + value['id'] + '"><img src="/Media/martup/assets/images/icons/icons8-lock-16.png" style="height: 16px; width: 16px;" alt=""></button>'+
                                            '</div> '+css+' '+newMsg);
                }
                // создаем массив с данными для каждого пользователя из списка для диалогового окна
                usersDataInChatList[value['id']] = {
                    'company_link': value['company_link'],
                    'company_name': value['company_name'],
                    'type_person': value['type_person'],
                    'lastname': value['lastname'],
                    'login': value['login'],
                    'name': value['name'],
                    'user_img': user_img,
                    'id': value['id']
                };
            });
            
            if(!$('div').is('#btnChatSettings')) {
                usersChatList.after('<div id="btnChatSettings"><img src="/Media/martup/assets/images/icons/icon-open-menu.svg" style="background: #fe980f;" alt=""></div>');
            }
        });
        
        $(document).on('click', '#AllUsers', function () {
            socket.emit('getUsersList', {show_status: 'All'});
        });
        
        $(document).on('click', '#showAllUsers', function () {
            socket.emit('getUsersList', {show_status: 1});
        });
        
        $(document).on('click', '#onlyHidenUsers', function () {
            socket.emit('getUsersList', {show_status: 0});
        });
        
        $(document).on('click', '.btnclose', function () {
            var id = $(this).attr('data');
            socket.emit('hideUserFromUserlist', {usr_to:id});
        });
        
        $(document).on('click', '.btndltusr', function () {
            var id = $(this).attr('data');
            $('#chatcont_'+id).remove();
            socket.emit('dltUserFromUserlist', {usr_to:id});
        });
        
        var audio_btn_icon = '/Media/martup/assets/images/icons/icons8-audio-16.png';
        var audio_btn_title = 'Volume on';
        $(document).on('click', '#Sound', function() {
            if($('#noSound').attr('data') === '1') {
                $('#noSound').attr('data', '0');
                $('#Sound').html('<img src="/Media/martup/assets/images/icons/icons8-mute-16.png" title="Volume off" alt="Volume off">');
                return false;
            }
        
            if($('#noSound').attr('data') === '0') {
                $('#noSound').attr('data', '1');
                $('#Sound').html('<img src="/Media/martup/assets/images/icons/icons8-audio-16.png" title="Volume on" alt="Volume on">');
                return false;
            }
        });
        
        $(document).on('click', '#btnChatSettings', function() {
            if(!$('div').is('#chatSettings')) {
                usersChatList.after('<div id="chatSettings">'+
                                        '<p id="AllUsers" title="Show all users"><img src="/Media/martup/assets/images/icons/icons8-user-groups-16.png" alt=""></p>'+
                                        '<p id="showAllUsers" title="Show online users"><img src="/Media/martup/assets/images/icons/icons8-consultation-16.png" alt=""></p>'+
                                        '<p id="onlyHidenUsers" title="Show offline users"><img src="/Media/martup/assets/images/icons/icons8-no-chat-16.png" alt=""></p>'+
                                        '<p id="Sound"><img src="/Media/martup/assets/images/icons/icons8-audio-16.png" title="Volume on" alt="Volume on"></p>'+
                                    '</div>');
            } else {
                $('#chatSettings').remove();
            }
        });
        /*-----/CREATE USERS LIST-----*/
        
        
        
        
        /*-----MESSAGE BOX DIALOG-----*/
        var saveTextFromTextarea = {};
        $(document).on('click','#message > img', function (e) { //открываем окно сообщений для того чтоб написать или ответить
            var e_id = $(this).parent().attr('data');
            if($('#chatcont_'+e_id).length === 0) {
                //console.log(usersDataInChatList);
                if (usersDataInChatList[e_id]['type_person'] == '4') {
                    var href = '/company/page/'+e_id;
                } else {
                    var href = '/portfolio/user/'+usersDataInChatList[e_id]['login'];
                }
                
                chatBox.append('<div class="chatcont" id="chatcont_'+usersDataInChatList[e_id]['id']+'">'+
                                    '<div class="headerMessageBox">'+
                                        '<div class="userData">'+
                                            '<div class="msgUserLogo">'+
                                                '<a href="'+href+'" title="'+usersDataInChatList[e_id]['lastname']+' '+usersDataInChatList[e_id]['name']+'">'+
                                                    '<img src="/'+usersDataInChatList[e_id]['user_img']+'" />'+
                                                '</a>'+
                                            '</div>'+
                                            '<div class="msgUserLogin">'+usersDataInChatList[e_id]['login']+'</div>'+
                                        '</div>'+
                                        '<div class="closeMessageBox" id="closeBoxChat" data="'+e_id+'">'+
                                            '<strong> × </strong>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="messageBlock" data="'+e_id+'"></div>'+
                                    '<div><textarea class="textarea" data="'+e_id+'"></textarea>'+
                                        '<div class="chat_icons" id="chat_icons_'+usersDataInChatList[e_id]['id']+'">'+
                                            '<p class="send_file" data="'+usersDataInChatList[e_id]['id']+'">'+
                                                '<img src="/Media/martup/assets/images/icons/icons8-clip-16.png" alt="">'+
                                            '</p>'+
                                            '<p class="add_smile" data="'+usersDataInChatList[e_id]['id']+'">'+
                                                '<img src="/Media/martup/assets/images/icons/icons8-smile-16.png" alt="">'+
                                            '</p>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                
                if (saveTextFromTextarea[e_id] !== '') $('.textarea[data='+e_id+']').val(saveTextFromTextarea[e_id]);
                
                $('.numNewMsg[data="'+e_id+'"]').remove(); //удаление иконки с количством новых сообщений
                
                //получаем историю сообщений
                socket.emit('getHistoryDialog', {usr_to: e_id});
                ///////-----------
            }
            $('.messageBlock').scrollTop($('.messageBlock').prop('scrollHeight'));
        });
        
        socket.on('addDialogHistory', function(data) { //добавляем историю сообщений в диалоговое окно пользователя
            data.arr.forEach(v => $('.messageBlock[data='+data.usr+']').append(function () {
                if($('#'+v.id).length === 0) {
                    //var msgUser = '<div class="msgUser">';
                    if( v.from_user_id === user_login) {
                        return '<p class="msgTo">'+v.message+'</p><p class="write_data_to">'+v.msg_data+'</p>';
                        //msgUser += '<a href="'+v.company_link+'" rel="nofollow noopener" target="_blank" title="'+v.company_name+'"><img src="/'+v.user_img+'" alt="'+v.login+'" title="'+v.lastname+' '+v.name+'" class="msgUserLogo" style="float:left;" /></a>';
                        //msgUser += '<p class="msgFrom" id="'+v.id+'">'+v.message+'</p>';
                    } else {
                        return '<p class="msgFrom" id="'+v.id+'">'+v.message+'</p><p class="write_data_from">'+v.msg_data+'</p>';
                        //msgUser += '<p class="msgTo" id="'+v.id+'">'+v.message+'</p>';
                        //msgUser += '<a href="'+v.company_link+'" rel="nofollow noopener" target="_blank" title="'+v.company_name+'"><img src="/'+v.user_img+'" alt="'+v.login+'" title="'+v.lastname+' '+v.name+'" class="msgUserLogo" style="float:right;" /></a>';
                    }
                    //msgUser += '</div>';
                    //return msgUser;
                }
            }));
            //крутим окно вниз
            $('.messageBlock').scrollTop($('.messageBlock').prop('scrollHeight'));
        });
        
        $(document).on('keyup', ".textarea", function(event){ //отправка сообщений нажатием на enter
            if(event.keyCode == 13 || event.keyCode == 10){
                if (event.ctrlKey) { // вот тут проверка, что Ctrl зажат. Поэтому просто выйти и ничего не делать, всё произойдёт само по себе.
                    insertTextAtCursor(this, '\n');
                    return;
                }
                
                event.preventDefault();
                if($(this).val() != '') {
                    socket.emit('send', {usr:$(this).attr('data'), msg: $(this).val()});
                    $('.messageBlock[data="'+$(this).attr('data')+'"]').append('<p class="msgTo">'+$(this).val()+'</p><p class="write_data_from">'+dataTime.getHours()+':'+dataTime.getMinutes()+'</p>');
                    $('.messageBlock[data="'+$(this).attr('data')+'"]').scrollTop($('.messageBlock[data="'+$(this).attr('data')+'"]').prop('scrollHeight'));
                    $(this).val('');
                } else return false;
            }
        });
        
        //delete message from author
        $(document).on('click', '.write_msg_del', function(){
            //socket.emit('deletemsg', {msgId: $(this).attr('id'), id_user_to: });
        });
        ///delete message from author
        
        socket.on('sendmsg', function  (data) {//показываем сообщение получателю
            if($('.messageBlock[data='+data.usr+']').length !== 0) { //если окно сообщений открыто
                $('.messageBlock[data='+data.usr+']').append('<p class="msgFrom">'+data.msg+'</p><p class="write_data_from">'+dataTime.getHours()+':'+dataTime.getMinutes()+'</p>');
                //обновляем статус сообщений на прочитано
                socket.emit('updateReadStatus', {usr_to:data.usr});
                $('.messageBlock[data='+data.usr+']').scrollTop($('.messageBlock[data='+data.usr+']').prop('scrollHeight'));
            }
            
            if($('.messageBlock[data='+data.usr+']').length === 0) {
                socket.emit('getUsersList', {show_status: 1});// обновляем список пользователей
                socket.emit('getNewMsgs', {usr_to:data.usr});//берем новые сообщния
                
                socket.on('setNewMsgs', function (data) {
                    $('.numNewMsg[data='+data.usr+']').remove();
                    $('.userMsgList[data='+data.usr+']').append('<div class="numNewMsg" data="'+data.usr+'">+'+data.num+'</div>');
                    
                    if($('#noSound').attr('data') === '1') {
                        if (incommingmsgPlay) incommingmsg.stop(incommingmsgPlay); // ещё играет - остановим
                        incommingmsgPlay = incommingmsg.play(); // играть сначала
                    }
                });
            }
        });
        
        socket.on('sendStatusUser', function(data) {
            if($('.messageBlock[data='+data.usr+']').length !== 0) {
                if($("p").is('.statusUser[data='+data.usr+']')) $('.statusUser[data='+data.usr+']').remove();
                $('.messageBlock[data='+data.usr+'] > p:last').after('<p class="statusUser" data="'+data.usr+'">'+data.msg+'</p>');
                $('.messageBlock').scrollTop($('.messageBlock').prop('scrollHeight'));
            }
        });
        
        $(document).on('click','#closeBoxChat',function(e){ //закрываем окно чата
            if($('.textarea[data='+$(this).attr('data')+']').val() !== '') { //если при закрытии окна есть текст
                saveTextFromTextarea[$(this).attr('data')] = $('.textarea[data='+$(this).attr('data')+']').val();
            }
            $('#chatcont_'+$(this).attr('data')).remove();
        });
        /*-----/MESSAGE BOX DIALOG-----*/
        
        
        
        /*-----UPLOAD | SMILE-----*/
        $(document).on('click', '.send_file', function () {
            var id = $(this).attr('data');
            if($('.input_upload_file[name='+id+']').length == 1) {
                $('.input_upload_file[name='+id+']').remove();
            } else $('#chat_icons_'+id).append('<input class="input_upload_file" type="file" name="'+id+'" />');
        });
        
        $(document).on('change', '.input_upload_file', function(e){
            e.preventDefault();
            
            var file_data = $(this).prop('files')[0]; //Берем Файл
            var form_data = new FormData();
            var id = $(this).attr('name');
            form_data.append('file', file_data);
            
            $.ajax({
                url: '/ajax/uploadDocument',
                type:'post',
                contentType: false,
                processData: false,
                data: form_data,
                dataType: 'text',
                cache: false,
                success: function (result) {
                    $('.messageBlock[data="'+id+'"]').append('<p class="fileFrom"><i>'+result+'</i></p>');
                    socket.emit('send', {usr:id, msg: result});
                    $('.input_upload_file[name='+id+']').remove();
                    $('.messageBlock[data='+data.usr+']').scrollTop($('.messageBlock[data='+data.usr+']').prop('scrollHeight'));
                }
            });
        });
        
        $(document).on('click', '.add_smile', function () {
            var id = $(this).attr('data');
        
            if($('.smile_chat[data='+id+']').length === 0) {
                $(this).append('<ul class="smile_chat" data="'+id+'"><li> &#128513; </li> <li> &#128514; </li> <li> &#128515; </li> <li> &#128516; </li> <li> &#128517; </li> <li> &#128518; </li> <li> &#128519; </li> <li> &#128520; </li><li> &#128521; </li> <li> &#128522; </li> <li> &#128523; </li> <li> &#128524; </li> <li> &#128525; </li> <li> &#128526; </li> <li> &#128527; </li> <li> &#128528; </li><li> &#128529; </li> <li> &#128530; </li> <li> &#128531; </li> <li> &#128532; </li> <li> &#128533; </li> <li> &#128534; </li> <li> &#128535; </li> <li> &#128536; </li><li> &#128537; </li> <li> &#128538; </li> <li> &#128539; </li> <li> &#128540; </li> <li> &#128541; </li> <li> &#128542; </li> <li> &#128543; </li> <li> &#128544; </li><li> &#128545; </li> <li> &#128546; </li> <li> &#128547; </li> <li> &#128548; </li> <li> &#128549; </li> <li> &#128550; </li> <li> &#128551; </li> <li> &#128552; </li><li> &#128553; </li> <li> &#128554; </li> <li> &#128555; </li> <li> &#128556; </li> <li> &#128557; </li> <li> &#128558; </li> <li> &#128559; </li> <li> &#128560; </li><li> &#128561; </li> <li> &#128562; </li> <li> &#128563; </li> <li> &#128564; </li> <li> &#128565; </li> <li> &#128566; </li> <li> &#128567; </li></ul>');
                return false;
            }
        
            if($('.smile_chat[data='+id+']').length !== 0) {
                $('.smile_chat[data='+id+']').remove();
                $('.textarea[data="'+id+'"]').focus();
            }
        });
        
        $(document).on('click', '.smile_chat li', function (){
            var id = $(this).parent('.smile_chat').attr('data');
            var textBefore = $('.textarea[data="'+id+'"]').val();
            $('.textarea[data="'+id+'"]').val(textBefore+$(this).html());
        });
        /*-----/UPLOAD | SMILE-----*/
        /*-----/START CHAT-----*/
    });
});
    
function insertTextAtCursor(el, text, offset) {
    var val = el.value, endIndex, range, doc = el.ownerDocument;
    if (typeof el.selectionStart == "number" && typeof el.selectionEnd == "number") {
        endIndex = el.selectionEnd;
        el.value = val.slice(0, endIndex) + text + val.slice(endIndex);
        el.selectionStart = el.selectionEnd = endIndex + text.length+(offset?offset:0);
    } else if (doc.selection != "undefined" && doc.selection.createRange) {
        el.focus();
        range = doc.selection.createRange();
        range.collapse(false);
        range.text = text;
        range.select();
    }
}
    
function BtnCreateChat(id, login) {
    if($("#createChat_"+$('div#online').attr('val')).length === 0) { //если еще нет кнопки, что автор в сети
        $('p#online'+id).append('<button data="'+id+'" id="createChat_'+id+'" class="createChat btn btn-radius btn-default btn-sm">'+login+' online</button>');
    }
}
